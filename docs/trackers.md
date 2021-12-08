# Trackers

In TREQ, Trackers are a request processing subsystem that apply user input to the persistance
layer (e.g. updates the database) and writes a log message saying what changed.

Trackers subsystem include Snapshots tooling that helps capture before and after state for
comparison and provides human readable description of that state for log messages.

## Assumptions

Data sent into the Tracker must be authorized and valid. Tracker system does not check 
appropriateness of requested updates, it just does them.

## Log Message Phrasing

We display our log messages in a table that has columns for the Date/Time, Actor, and then 
the message. To make the language consistent and readable the log message should be a 
sentence predicate (phrase that follows the actor/subject) written in the past tense.

+----------------+---------------+----------------------------------------------------+
| Date/Time      | Actor         | Message                                            |
+----------------+---------------+----------------------------------------------------+
| 5/1/20 08:15   | John Smith    | set name = Foo, age = 13                           |
| 5/1/20 08:21   | John Smith    | changed budgets, deleted 02-0820                   |
| 5/2/20 07:15   | Wen Nyguen    | added note "Invoice will come later..."            |
| 5/2/20 10:15   | Mary Jones    | canceled order                                     |
+----------------+---------------+----------------------------------------------------+

Examples of bad messages.

* "add Ariba reference" - not in past tense
* "canceled by Joe Zeus" - includes actor, will display redundant
* "Total was set to $500." - implies an actor, formatted as complete sentence instead of 
   predicate phrase

## Snapshots

Snapshots are a strategy for capturing the state of a record at a specific point in time.

To find and log differences you need two Snapshots, one taken before the update and one 
after the update.

Specific Snapshot implementations know how to capture state for a set of fields related to 
a specific update routine. For each type of LoggedUpdate you implement you will likely need 
a matching Snapshot implementation.

During construction a Snapshot implementation populates its own $state property. The 
$state property must contain an associative array where the array keys are strings that
describe a single field and the array values are instances of `SnapField`.

The array keys (e.g. labels) will be used to build a log message when a there is a 
difference between the two Snapshots. Labels should be human-readable descriptions of the 
field.

    class ProjectSnapshot extends Snapshot
    {
        public function __construct(Project $project)
        {
            $this->state = [
                // labels   => SnapField instances
                'title' => Snap::text($project->title),
                'owner' => Snap::personId($project->person_id),
                'purpose' => Snap::truncate($project->purpose),
                'food' => Snap::yesNo($project->is_food),
                'gift card' => Snap::yesNo($project->is_gift_card),
            ];
        }
    
        public function getItemLabel(): string
        {
            return 'project';
        }
    }

### Item Label

The string returned by `getItemLabel()` will be added to log message to specifically identify 
a subrecord that changed.

For example: it could return "project" when fields on the Project model get updated.

The returned string could identify a specific sub-record, instead of a class of sub-record. 
For example: it could return "02-0820" when logging updates to a specific budget record.

It can just be blank (empty string '') when the log message belongs to default context, for 
TREQ that would be an Order. 

### SnapFields

SnapFields are classes that deal with a specific type of value for difference checking and 
logging.

SnapFields normalize values so comparisons are simpler. For example: it converts NULL values 
and empty string values to a single representation.

SnapFields also provide a strategy for representing a value in a log message. For example:
it converts a Person::id into a string "Firstname Lastname".

Tracker currently includes theses SnapField types:

* `SnapField` - regular text field
* `SnapDate` - Carbon date field where only the date part (not time) is significant
* `SnapPerson` - field that contains a person_id foreign key
* `SnapTruncate` - long text field, example: a note, only a portion of it is included in 
   log message (default: words in the first 30 characters)
* `SnapYesNo` - boolean 0/1 or Y/N field, represented as "Yes", "No", or empty

The `Snap` class is a collection of static factory methods. It provides a succinct syntax
for $state construction in `Snapshot` implementations.

## LoggedUpdate

The `LoggedUpdate` base class provides a structure to process requests that may log field
by field changes. The base class provides an `update()` implementation that does the 
following:

* Take a before Snapshot
* Call the implementation's applyPatch() routine
* Take an after Snapshot
* If there are differences in the Snapshots, log the differences

The `update()` routine also respects the `$shouldLog` flag that can be modified at 
runtime.

### Implementing LoggedUpdate

LoggedUpdate follows the Command pattern. All of its input should be passed in at the 
constructor and `execute()` method should be its external trigger.

By convention I am expecting that a $patch argument will be passed in at construction 
which contains the values to be applied to the model. $patch can be an associative 
array retrieved from the Formkit\Form or Laravel\Request objects.

#### applyPatch()

Apply the $patch input to the domain model (generally Laravel Eloquent objects) and 
then persist. A simple implemenation might look like this.

    protected function applyPatch()
    {
        $this->model->fill($this->patch);
        $this->model->save();
    }

#### execute()

Do whatever this specific update does. I've left this method abstract for branching logic 
or setup. If we are using the `LoggedUpdate` base class, we probably want to call its 
`update()` method at some point.

Here is an example implementation that branches based on new records vs updating an existing
record.

    public function execute()
    {
        if ($this->model->exists) {
            $this->update();
        } else {
            $this->applyPatch();
            $this->writeLog('creating new widget ' . $this->model->name);
        }
    }

#### newSnapshot()

This method should generate a new Snapshot instance. It will be called both before and 
again after the `applyPatch()` method is run, allowing a difference to be generated.

The default implementation just returns null. Returning null tells the base `update()` 
routine to not compare snapshots and therefore not log changes.

Example:

    protected function newSnapshot(): ?Snapshot
    {
        return new WidgetSnapshot($this->model);
    }

#### writeLog()

Finally, the writeLog() method will receive a string message to store in the log. Here
is an example implementation.

    protected function writeLog($message)
    {
        $log = new OrderLog([
            'order_id' => $this->order->id,
            'actor_id' => $this->actor_id,
            'project_id' => $this->project->id,
            'message' => $message,
        ]);
        $log->save();
    }

## Other Logged Actions

Some actions need to be saved to the database and logged, but don't need field-by-field 
change logging implemented in `LoggedUpdate`.

In these cases a stand-alone class can be added to the Tracker directory. It fits here 
because it is a command that stores data, then logs what happened.

An example is canceling an order. You need to update the database then write a log message,
but you don't need Snapshots to know what changed and what should be logged.

    class LoggedCancelOrder
    {
        private $order;
        
        public function __construct(Order $order)
        {
            $this->order = $order;
        }
        
        public function execute()
        {
            $this->order->cancel();
            $this->writeLog('canceled order');
        }
    }
