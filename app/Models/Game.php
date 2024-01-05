<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RentedGame;

class Game extends Model
{
    use HasFactory;

    protected $table = 'game';

    protected $primaryKey = 'gameID';   

    protected $fillable = [
        'game_title',
        'game_rating',
        'game_store_type',
        'game_price',
        'game_discount',
        'game_image',
        'game_video_link',
        'game_description',
        'game_developer',
        'game_publisher',
        'game_release_date',
    ];

    public function rentedGames()
    {
        return $this->hasMany(RentedGame::class, 'gameID');
    }
}
