<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name'];      //nameはタスク名のカラム、

    /**
     * タスクを保持するユーザーの取得
     */
    public function user()
    {
        return $this->belongsTo(User::class);   //userのデータを取得することができる
    }
}
