<?php
namespace App\Models;

use App\Auth\User;
use App\Views\PerdiemView;
use App\Workflows\Templates\Template;
use App\Workflows\Templates\TemplateFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Scalar\String_;

/**
 * @property integer $id
 * @property integer $project_id
 * @property string $type
 * @property string $stage
 * @property Carbon $submitted_at
 * @property integer $submitted_by
 * @property float $amount
 * @property Carbon $active_at
 * @property Carbon $notified_at
 * @property integer $assigned_to
 * @property boolean $on_call
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * ----------   Relationships   ----------
 * @property Ariba[] $aribas
 * @property Person $assignee
 * @property Budget[] $budgets
 * @property Item[] $items
 * @property Perdiem $perdiem
 * @property Project $project
 * @property Person $submitter
 * @property Task[] $tasks
 * @property Tracking $tracking
 */
class Order extends Model
{
    const STAGE_BUDGET = 'Budget Approval';
    const STAGE_CANCELED = 'Canceled';
    const STAGE_COMPLETE = 'Complete';
    const STAGE_CREATING = 'Creating';
    const STAGE_DEPARTMENT = 'Department Approval';
    const STAGE_RESUBMITTED = 'Re-Submitted';
    const STAGE_SENT_BACK = 'Sent Back';
    const STAGE_UNASSIGNED = 'Unassigned';

    public static $types = [
        'travel-pre-auth' => 'Travel Pre-Authorization',
        'travel-reimbursement' => 'Travel Reimbursement',
        'pre-auth' => 'Pre-Authorization',
        'purchase' => 'Purchase',
        'reimbursement' => 'Reimbursement',
        'invoice' => 'Pay Invoice',
    ];

    protected $table = 'orders';
    protected $fillable = [
        'project_id',
        'type',
        'stage',
        'submitted_at',
        'submitted_by',
        'amount',
        'active_at',
        'notified_at',
        'assigned_to',
        'on_call',
    ];
    protected $casts = [
        'submitted_at',
        'active_at',
        'notified_at',
        'created_at',
        'updated_at',
    ];

    private $_perDiemView;
    private $_tripNotesCollection;

    public function canCancel(User $user)
    {
        if ($this->stage === self::STAGE_CANCELED || $this->stage === self::STAGE_COMPLETE) {
            return false;
        }
        return $user->person_id == $this->submitted_by || hasRole('cancel', $user);
    }

    public function cancel()
    {
        if ($this->stage !== self::STAGE_CANCELED) {
            $this->stage = self::STAGE_CANCELED;
            $this->notified_at = null;
            $this->save();
        }
    }

    public function complete()
    {
        if ($this->stage !== self::STAGE_COMPLETE) {
            $this->stage = self::STAGE_COMPLETE;
            $this->notified_at = null;
            $this->save();
        }
    }

    public function getTripNotes()
    {
        if (!$this->_tripNotesCollection) {
            $this->_tripNotesCollection = new TripNotesCollection($this->id);
        }
        return $this->_tripNotesCollection->notes;
    }

    public function hasTripNotes()
    {
        return $this->type === 'travel-reimbursement';
    }

    public function isCanceled()
    {
        return $this->stage === self::STAGE_CANCELED;
    }

    public function isComplete()
    {
        return $this->stage === self::STAGE_COMPLETE;
    }

    public function isPreAuth()
    {
        return $this->type === 'travel-pre-auth' || $this->type === 'pre-auth';
    }

    public function isResubmitted()
    {
        return $this->stage === self::STAGE_RESUBMITTED;
    }

    public function isSentBack()
    {
        return $this->stage === self::STAGE_SENT_BACK;
    }

    public function isSubmitted()
    {
        return (bool) $this->submitted_at;
    }

    public function isTravel()
    {
        return $this->type && strpos($this->type, 'travel-') === 0;
    }

    public function itemsTotalAmount()
    {
        $total = 0.00;
        foreach ($this->items as $item) {
            $total += (float) str_replace(',', '', $item->lineTotal());
        }

        if ($this->isTravel()) {
            $pdv = $this->perDiemView();
            $total += (float) $pdv->meals;
            $total += (float) $pdv->lodging;
        }

        return number_format($total, 2);
    }

    public function perDiemView()
    {
        if ($this->_perDiemView === null) {
            $this->_perDiemView = new PerdiemView($this);
        }
        return $this->_perDiemView;
    }

    public function resubmit($person_id = null)
    {
        if (!$this->submitted_at || $this->stage === self::STAGE_SENT_BACK) {
            $this->stage = self::STAGE_RESUBMITTED;
            $this->submitted_at = now();
            $this->submitted_by = $person_id ?? $this->submitted_by;
            $this->save();
        }
    }

    public function sectionNotes($section)
    {
        return $this->notes()->where('section', $section)->get();
    }

    public function sendBack()
    {
        if ($this->stage !== self::STAGE_SENT_BACK) {
            $this->stage = self::STAGE_SENT_BACK;
            $this->submitted_at = null;
            $this->notified_at = null;
            $this->save();
        }
    }

    public function shouldLog()
    {
        return $this->submitted_at || $this->stage === self::STAGE_SENT_BACK;
    }

    public function template(): Template
    {
        return (new TemplateFactory())->get($this->type);
    }

    public function title(): String
    {
        return "Order ({$this->id})";
    }

    public function tripUrlSegment()
    {
        return ($this->isTravel()) ? '/trip' : '';
    }

    public function typeName(): string
    {
        if (!$this->type) {
            return 'Unknown Order Type';
        }
        if (isset(self::$types[$this->type])) {
            return self::$types[$this->type];
        }
        return $this->type;
    }

    public function updateTracking()
    {
        $tracking = Tracking::firstOrNew(['order_id' => $this->id]);
        $tracking->track($this);
    }

    public function assignee()
    {
        return $this->hasOne(Person::class, 'person_id', 'assigned_to');
    }

    public function aribas()
    {
        return $this->hasMany(Ariba::class, 'order_id', 'id')->with('person');
    }

    public function budgets()
    {
        return $this->hasMany(Budget::class, 'order_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'order_id', 'id');
    }

    public function notes()
    {
        return $this->hasMany(Note::class, 'order_id', 'id')
            ->orderBy('created_at', 'desc')
            ->with('person');
    }

    public function perdiem()
    {
        return $this->hasOne(Perdiem::class, 'order_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function submitter()
    {
        return $this->belongsTo(Person::class, 'submitted_by', 'person_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'order_id', 'id')
            ->orderBy(DB::raw('ISNULL(completed_at)'))
            ->orderBy('completed_at')
            ->orderBy('created_at')
            ->with(['creator', 'assignee', 'completer']);
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class, 'order_id', 'id');
    }

    public function preSave()
    {
        if (!isset(self::$types[$this->type])) {
            throw new \Exception("Invalid value for Order type '{$this->type}'");
        }
        return parent::preSave();
    }
}
