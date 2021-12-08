<?php

namespace App\Models;

use App\Utilities\FirstWords;

class TripNotesResponse
{
    public $item;
    public $label;
    public $question;
    public $answer;
    public $note;
    public $options;

    public $wasModified;
    public $logMessage;

    private $order_id;
    private $tripNoteModel;

    public function __construct($order_id, $item, $label, $question, $options = null)
    {
        $this->order_id = $order_id;
        $this->item = $item;
        $this->label = $label;
        $this->question = $question;
        $this->options = $options;
    }

    public function answerClass()
    {
        if ($this->answer === 'Y') {
            return 'yes';
        }
        if ($this->answer === 'N') {
            return 'no';
        }
        return 'empty';
    }

    public function isEmpty()
    {
        return !$this->answer && !$this->note;
    }

    public function load(TripNote $tn)
    {
        $this->tripNoteModel = $tn;
        $this->answer = $tn->answer;
        $this->note = $tn->note;
        $this->wasModified = false;
        $this->logMessage = '';
    }

    public function save($answer, $note)
    {
        if (!$answer && !$note) {
            $this->delete();
        } else {
            if ($this->tripNoteModel) {
                $this->update($answer, $note);
            } else {
                $this->insert($answer, $note);
            }
        }
    }

    private function insert($answer, $note)
    {
        $this->answer = $answer;
        $this->note = $note;

        $tn = TripNote::firstOrNew([
            'order_id' => $this->order_id,
            'item' => $this->item,
        ]);
        $tn->fill([
            'answer' => $this->answer,
            'note' => $this->note,
        ]);
        $tn->save();
        $this->tripNoteModel = $tn;

        $this->wasModified = true;
        $this->logMessage = "{$this->label}: " . $this->answer;
    }

    private function update($answer, $note)
    {
        $changes = [];
        if ($answer != $this->answer) {
            $this->tripNoteModel->answer = $this->answer = $answer;
            $changes[] = $answer;
        }

        if ($note != $this->note) {
            $this->tripNoteModel->note = $this->note = $note;
            $fw = new FirstWords();
            $changes[] = '('. $fw->getFirstWords($note, 20) .')';
        }

        if ($changes) {
            $this->tripNoteModel->save();
            $this->wasModified = true;
            $this->logMessage = "{$this->label}: " . implode(' ', $changes);
        }
    }

    private function delete()
    {
        if (!$this->tripNoteModel) {
            return;
        }
        $this->tripNoteModel->delete();

        $this->tripNoteModel = null;
        $this->wasModified = true;
        $this->logMessage = "deleted {$this->label}";
    }
}
