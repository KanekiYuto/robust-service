<?php

namespace KanekiYuto\Handy\Cascades\Model;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use KanekiYuto\Handy\Trace\TraceEloquent;
use Illuminate\Foundation\Auth\User as Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthenticateModel extends Authenticate
{

	use HasApiTokens, HasFactory, Notifiable;

	/**
	 * 追踪类
	 *
	 * @var string
	 */
	protected string $trace = TraceEloquent::class;

}