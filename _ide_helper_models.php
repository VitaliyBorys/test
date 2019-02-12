<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $lastname
 * @property string $email
 * @property string|null $phone
 * @property string|null $avatar
 * @property \Carbon\Carbon|null $birthday
 * @property string|null $gender
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string|null $bio
 * @property string $password
 * @property bool $confirmed
 * @property string|null $confirm_token
 * @property string $ref_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Ensemble[] $ensembles
 * @property-read mixed $age
 * @property-read mixed $connection_type
 * @property-read mixed $connections
 * @property-read mixed $connections_count
 * @property-read mixed $fullname
 * @property-read mixed $incoming_connections_count
 * @property-read mixed $location
 * @property-read mixed $plays
 * @property-read mixed $small_avatar
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Instrument[] $instruments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Language[] $languages
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Connection[] $relatedConnectionIn
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Connection[] $relatedConnectionOut
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User connectedTo($connection_type = 'all', $userId = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User filter(\App\Filters\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User search($search = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRefToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ensemble
 *
 * @property int $id
 * @property string $title
 * @property string|null $poster
 * @property string|null $description
 * @property int|null $country_id
 * @property int|null $city_id
 * @property string|null $founded
 * @property string|null $ended
 * @property string $ref_token
 * @property \App\Models\City|null $city
 * @property \App\Models\Country|null $country
 * @property-read mixed $fans_count
 * @property-read mixed $members
 * @property-read mixed $members_count
 * @property-read mixed $possible_count
 * @property-read mixed $possible_members
 * @property-read mixed $small_poster
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble filter(\App\Filters\Filter $filter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble search($search = '')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereEnded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereFounded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble wherePoster($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereRefToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Ensemble whereTitle($value)
 */
	class Ensemble extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\City[] $cities
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereName($value)
 */
	class Country extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Connection
 *
 * @property int $id
 * @property int $user1_id
 * @property int $user2_id
 * @property int $user1_status
 * @property int $user2_status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUser1Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUser1Status($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUser2Id($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Connection whereUser2Status($value)
 */
	class Connection extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\City
 *
 * @property int $id
 * @property int $country_id
 * @property string $name
 * @property-read \App\Models\Country $country
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\City whereName($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Instrument
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instrument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Instrument whereName($value)
 */
	class Instrument extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Language whereName($value)
 */
	class Language extends \Eloquent {}
}

