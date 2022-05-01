<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use  HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'username', 'karma_score', 'image_id'
    ];

    protected $hidden = [
        'image_id', 'image', 'username'
    ];

    protected $appends = [
        'image_url'
    ];

    public static function getUserRank($userId, int $totalCount = 5): Collection
    {
        $user = User::query()->findOrFail($userId);

        $baCount = $totalCount / 2;

        $usersLower = self::getUsersWithLowerScore($user, $baCount);

        $usersHigher = self::getUsersWithHigherScore($user, $baCount);

        $users = new Collection();
        $users->push($user);
        while ($users->count() != $totalCount && ($usersLower->isNotEmpty() || $usersHigher->isNotEmpty())) {
            $u = $usersLower->shift();
            if ($u != null) $users->prepend($u);

            if ($users->count() == $totalCount) break;

            $u = $usersHigher->shift();
            if ($u != null) $users->push($u);
        }

        self::calcPosition($users);
        return $users;
    }

    //It can be replaced with calculated property
    private static function calcPosition(Collection &$users)
    {
        $lowestUser = $users->first();
        $lastPosition = self::getPosition($lowestUser->karma_score);

        foreach ($users as $user) {
            $user->attributes['position'] = $lastPosition;
            $lastPosition++;
        }
    }

    /**
     * @param $user
     * @param $baCount
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    protected static function getUsersWithHigherScore($user, $baCount)
    {
        return User::query()
            ->where('karma_score', '>=', $user->karma_score)
            ->where('id', '<>', $user->id)
            ->orderBy('karma_score')
            ->take($baCount)->get();
    }

    /**
     * @param $user
     * @param $baCount
     * @return \Illuminate\Database\Eloquent\Builder[]|Collection
     */
    protected static function getUsersWithLowerScore($user, $baCount)
    {
        return User::query()
            ->where('karma_score', '<=', $user->karma_score)
            ->where('id', '<>', $user->id)
            ->orderBy('karma_score', 'desc')
            ->take($baCount)->get();
    }

    /**
     * @param $karmaScore
     * @return int
     */
    public static function getPosition($karmaScore): int
    {
        //TODO: Need to handle score equality case
        return User::query()
            ->where('karma_score', '<', $karmaScore)
            ->count();
    }

    public function getImageUrlAttribute()
    {
        return $this->image->url;
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
