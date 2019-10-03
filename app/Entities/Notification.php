<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use LaravelDoctrine\ORM\Notifications\Notification as NotificationContract;

/**
 * @ORM\Entity
 */
class Notification extends NotificationContract
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entities\User")
     */
    protected $user;}