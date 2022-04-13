<?php

namespace App\Http\Controllers;

use App\Helpers\PollHandler;
use App\Http\Controllers\Controller;
use App\Http\Request\AddOptionsRequest;
use App\Poll;
use App\WebmasterSection;
use Auth;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OptionManagerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if (@Auth::user()->permissions_id == 3) {
            Redirect::to('/home')->send();
            exit();
        }
    }

    /**
     * Add new options to the poll
     *
     * @param Poll $poll
     * @param AddOptionsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add(Poll $poll, AddOptionsRequest $request)
    {
        $poll->attach($request->get('options'));

        return redirect(route('poll.index'))
            ->with('success', 'New poll options have been added successfully');
    }

    /**
     * Remove the Selected Option
     *
     * @param Poll $poll
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function remove(Poll $poll, Request $request)
    {
        try {
            $poll->detach($request->get('options'));

            return redirect(route('poll.index'))
                ->with('success', 'Poll options have been removed successfully');
        } catch (Exception $e) {
            return back()->withErrors(PollHandler::getMessage($e));
        }
    }

    /**
     * Page to add new options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function push(Poll $poll)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);

        return view('backEnd.poll.options.push', compact('poll', 'GeneralWebmasterSections', 'WebmasterSection'));
    }

    /**
     * Page to delete Options
     *
     * @param Poll $poll
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function delete(Poll $poll)
    {
        $GeneralWebmasterSections = WebmasterSection::where('status', '=', '1')->orderby('row_no', 'asc')->get();
        $WebmasterSection = WebmasterSection::find(1);

        return view('backEnd.poll.options.remove', compact('poll', 'GeneralWebmasterSections', 'WebmasterSection'));
    }
}
