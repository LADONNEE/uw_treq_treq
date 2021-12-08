<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Note;
use App\Trackers\LoggedNote;

class NoteApiController extends Controller
{
    public function index(Order $order, $section = null)
    {
        $query = $order->notes();

        if ($section && $section !== Note::DEFAULT_SECTION) {
            $query->where('section', $section);
        }

        return response()->json($this->annotatedNoteList($query->get()));
    }

    public function store(Order $order, $section)
    {
        $noteText = request('note');
        if (!$noteText) {
            return response()->json([
                'http_status' => 400,
                'message' => 'Ignored. Empty note.',
            ], 400);
        }

        $note = new Note([
            'order_id' => $order->id,
            'section' => $section,
        ]);

        $this->save($note, $noteText, $order);

        return response()->json($this->annotatedNote($note));
    }

    public function update(Note $note)
    {
        if (request('_action') === 'delete') {
            return $this->destroy($note);
        }

        $noteText = request('note');
        if (!$noteText) {
            return $this->destroy($note);
        }

        $this->save($note, $noteText);

        return response()->json($this->annotatedNote($note));
    }

    public function destroy(Note $note)
    {
        $this->save($note, false);

        return response()->json([
            'message' => 'deleted',
            'id' => $note->id,
        ]);
    }

    private function save(Note $note, $noteText = null, $order = null)
    {
        $order = ($order instanceof Order) ? $order : $note->order;
        $cmd = new LoggedNote($note, user()->person_id, $noteText);
        $cmd->shouldLog = $order->shouldLog();

        if ($noteText) {
            $cmd->execute();
        } else {
            $cmd->delete();
        }
    }

    private function annotatedNote(Note $note)
    {
        if (!$note->relationLoaded('person')) {
            $note->load('person');
        }
        $out = $note->toArray();

        if ($note->wasEdited()) {
            $out['edited'] = $note->editedMessage();
        } else {
            $out['edited'] = false;
        }

        $out['can_edit'] = $note->userCanEdit(user());

        return $out;
    }

    private function annotatedNoteList($items)
    {
        $out = [];
        foreach ($items as $note) {
            $out[] = $this->annotatedNote($note);
        }

        return $out;
    }
}
