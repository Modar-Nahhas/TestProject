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

    public static function getUserRankBetween($userId, int $totalCount = 5): Collection
    {
        $user = User::query()->findOrFail($userId);

        $baCount = $totalCount / 2;

        $usersBefore = User::query()
            ->where('karma_score', '<=', $user->karma_score)
            ->where('id', '<>', $user->id)
            ->orderBy('karma_score', 'desc')
            ->take($baCount)->get();

        $usersAfter = User::query()
            ->where('karma_score', '>=', $user->karma_score)
            ->where('id', '<>', $user->id)
            ->orderBy('karma_score')
            ->take($baCount)->get();

        $users = new Collection();
        $users->push($user);
        while ($users->count() != $totalCount && ($usersBefore->isNotEmpty() || $usersAfter->isNotEmpty())) {
            $u = $usersBefore->shift();
            if ($u != null) $users->push($u);

            if ($users->count() == $totalCount) break;

            $u = $usersAfter->shift();
            if ($u != null) $users->prepend($u);
        }

        self::calcPosition($users);
        return $users;
    }

    private static function calcPosition(Collection &$users)
    {
        $lastUser = $users->last();
        $lastPosition = User::query()->where('karma_score', '>=', $lastUser->karma_score)->count();
        foreach ($users->reverse() as $user) {
            $user->attributes['position'] = $lastPosition;
            $lastPosition--;
        }
    }

    public function getImageUrlAttribute()
    {
        return $this->image->url;
    }

//    public function getPositionAttribute(): int
//    {
//        return User::query()->where('karma_score', '<=', $this->karma_score)->count();
//    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }
}
