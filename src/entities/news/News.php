<?php

namespace Oportunista\entities\news;

use Oportunista\entities\subject\SubjectDao;
use Oportunista\entities\users\User;

class News
{
    protected $id;
    protected $title;
    protected $description;
    protected $author;
    protected $subject;
    protected $created;
    protected $lastUpdate;

    public function __construct($params, User $user)
    {
        $this->id = $params->id ?? null;
        $this->title = $params->title ?? null;
        $this->description = $params->description ?? null;
        $this->created = $params->created ?? null;
        $this->lastUpdate = $params->created ?? null;
        $this->author = $user ?? null;
        $this->subject = SubjectDao::find($params->subjectId);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function getSubject()
    {
        return $this->subject;
    }



}