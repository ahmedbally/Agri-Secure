<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\PollHandler;
use App\Http\Request\PollCreationRequest;
use App\Poll;
use App\Exceptions\DuplicatedOptionsException;
use App\WebmasterSection;
use Auth;

class PollManagerController extends Controller
{
    /**
     * Dashboard Home
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('auth');
        if(@Auth::user()->permissions_id == 3){
            Redirect::to('Home')->send();
        }
    }

    public function home()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);
        return view('backEnd.poll.home', compact("GeneralWebmasterSections", "WebmasterSection"));
    }
    /**
     * Show all the Polls in the database
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);

        $polls = Poll::withCount('options', 'votes')->latest()->paginate(
            config('larapoll_config.pagination')
        );
        return view('backEnd.poll.index', compact('polls', "GeneralWebmasterSections", "WebmasterSection"));
    }

    /**
     * Store the Request
     *
     * @param PollCreationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\CheckedOptionsException
     * @throws \App\Exceptions\OptionsInvalidNumberProvidedException
     * @throws \App\Exceptions\OptionsNotProvidedException
     */
    public function store(PollCreationRequest $request)
    {
        try {
            PollHandler::createFromRequest($request->all());
        } catch (DuplicatedOptionsException $exception) {
            return redirect(route('poll.create'))
                ->withInput($request->all())
                ->with('danger', $exception->getMessage());
        }

        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been addedd successfully');
    }

    /**
     * Show the poll to be prepared to edit
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Poll $poll)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);
        return view('backEnd.poll.edit', compact('poll',"GeneralWebmasterSections", "WebmasterSection"));
    }

    /**
     * Update the Poll
     *
     * @param Poll $poll
     * @param PollCreationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Poll $poll, PollCreationRequest $request)
    {
        PollHandler::modify($poll, $request->all());
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been updated successfully');
    }

    /**
     * Delete a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll)
    {
        $poll->remove();

        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been deleted successfully');
    }
    public function create()
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);

        return view('backEnd.poll.create', compact("GeneralWebmasterSections", "WebmasterSection"));
    }

    /**
     * Lock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function lock(Poll $poll)
    {
        $poll->lock();
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been locked successfully');
    }

    /**
     * Unlock a Poll
     *
     * @param Poll $poll
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlock(Poll $poll)
    {
        $poll->unLock();
        return redirect(route('poll.index'))
            ->with('success', 'Your poll has been unlocked successfully');
    }
}
