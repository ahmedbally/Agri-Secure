<?php

namespace App;

use App\Traits\Votable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Votable;

    protected $fillable = ['name'];

    protected $table = 'larapoll_options';

    /**
     * An option belongs to one poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Check if the option is Closed
     *
     * @return bool
     */
    public function isPollClosed()
    {
        return $this->poll->isLocked();
    }
}
