<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Members
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @property string $email
 * @property string|null $country
 * @property string|null $city
 * @property string|null $address
 * @property string|null $state
 * @property string|null $postal_code
 * @property string|null $customer_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Subscriptions[] $subscriptions
 * @property-read int|null $subscriptions_count
 * @method static \Illuminate\Database\Eloquent\Builder|Members newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Members newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Members query()
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Members whereUpdatedAt($value)
 */
	class Members extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscriptions
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $members_id
 * @property string $currency
 * @property string $status
 * @property float $amount
 * @property string $payment_method
 * @property-read \App\Models\Members|null $members
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereMembersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriptions whereUpdatedAt($value)
 */
	class Subscriptions extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

