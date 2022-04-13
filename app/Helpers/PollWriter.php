<?php

namespace App\Helpers;

use App\Guest;
use App\Poll;
use App\Traits\PollWriterResults;
use App\Traits\PollWriterVoting;

class PollWriter
{
    use PollWriterResults,
        PollWriterVoting;

    /**
     * Draw a Poll
     *
     * @param Poll $poll
     * @return string
     */
    public function draw($poll)
    {
        if (is_int($poll)) {
            $poll = Poll::findOrFail($poll);
        }

        if (! $poll instanceof Poll) {
            throw new \InvalidArgumentException('The argument must be an integer or an instance of Poll');
        }

        if ($poll->isComingSoon()) {
            return 'To start soon';
        }

        if (! $poll->showResultsEnabled()) {
            return 'Thanks for voting';
        }

        $voter = $poll->canGuestVote() ? new Guest(request()) : auth(config('larapoll_config.admin_guard'))->user();

        if (is_null($voter) || $voter->hasVoted($poll->id) || $poll->isLocked()) {
            return $this->drawResult($poll);
        }

        if ($poll->isRadio()) {
            return $this->drawRadio($poll);
        }

        return $this->drawCheckbox($poll);
    }
}
