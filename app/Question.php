<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use VotableTrait;
    
    protected $fillable = ['title', 'body'];

    protected $appends = ['created_date'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function answers() {
        return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');
    }

    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps(); //, 'question_id', 'user_id'); incase if id do not follow laravel schema conventions <model>_id
    }

    public function acceptBestAnswer(Answer $answer) {
        $this->best_answer_id = $answer->id;
        $this->save();
    }

    public function setTitleAttribute($value) {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
        $this->attributes['slug'] = str_slug($value);
    }

    public function getUrlAttribute() {
        return route("questions.show", $this->slug);
    }

    public function getCreatedDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function getExceprtAttribute()
    {
        return $this->Exceprt(250);
    }

    public function Exceprt($length)
    {
        return clean(str_limit($this->getHtmlBody(), $length));
    }

    public function isFavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->count() > 0;
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function getStatusAttribute() {
        if ($this->answers_count > 0) {
            if ($this->best_answered_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }

    public function getBodyHtmlAttribute() {
        return clean($this->getHtmlBody());
    }
    
    private function getHtmlBody()
    {
        return \Parsedown::instance()->text($this->body);
    }
    
}