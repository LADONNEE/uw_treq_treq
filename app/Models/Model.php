<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    public function save(array $options = [])
    {
        $update = $this->exists;
        $ok = $this->preSave();
        if ($ok === false) {
            return false;
        }
        if ($update) {
            $ok = $this->preUpdate();
        } else {
            $ok = $this->preInsert();
        }
        if ($ok === false) {
            return false;
        }
        $ok = parent::save($options);
        $this->postSave();
        if ($update) {
            $this->postUpdate();
        } else {
            $this->postInsert();
        }
        return $ok;
    }

    public function delete()
    {
        $ok = $this->preDelete();
        if ($ok === false) {
            return false;
        }
        $ok = parent::delete();
        $this->postDelete();
        return $ok;
    }

    protected function preSave()
    {
        return true;
    }

    protected function postSave()
    {
        return true;
    }

    protected function preInsert()
    {
        return true;
    }

    protected function postInsert()
    {
        return true;
    }

    protected function preUpdate()
    {
        return true;
    }

    protected function postUpdate()
    {
        return true;
    }

    protected function preDelete()
    {
        return true;
    }

    protected function postDelete()
    {
        return true;
    }
}
