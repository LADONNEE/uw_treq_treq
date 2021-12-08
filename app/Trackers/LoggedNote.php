<?php

namespace App\Trackers;

use App\Models\Note;
use App\Models\OrderLog;
use App\Trackers\Snapshots\Snap;

class LoggedNote
{
    private $note;
    private $actor_id;
    private $noteText;

    public $shouldLog = true;

    public function __construct(Note $note, $actor_id, $noteText = null)
    {
        $this->note = $note;
        $this->actor_id = $actor_id;
        $this->noteText = $noteText;
    }

    public function execute()
    {
        if (!$this->noteText) {
            return;
        }
        if ($this->note->exists) {
            $this->update();
        } else {
            $this->applyPatch();
            $snippet = Snap::truncate($this->note->note)->format();
            $this->writeLog("added note \"{$snippet}\"");
        }
    }

    protected function update()
    {
        $before = ($this->shouldLog) ? Snap::truncate($this->note->note) : null;

        $this->applyPatch();

        if (!$before) {
            return;
        }

        $after = Snap::truncate($this->note->note);

        if ($before->isChanged($after)) {
            $snippet = $after->format();
            $this->writeLog("edited note \"{$snippet}\"");
        }
    }

    public function delete()
    {
        $snippet = Snap::truncate($this->note->note)->format();
        $this->note->delete();
        $this->writeLog("deleted note \"{$snippet}\"");
    }

    protected function applyPatch()
    {
        if ($this->noteText && $this->noteText !== $this->note->note) {
            $this->note->note = $this->noteText;
            $this->note->editedBy($this->actor_id);
            $this->note->save();
        }
    }

    protected function writeLog($message)
    {
        if (!$this->shouldLog) {
            return;
        }
        $log = new OrderLog([
            'order_id' => $this->note->order_id,
            'actor_id' => $this->actor_id,
            'message' => $message,
        ]);
        $log->save();
    }
}
