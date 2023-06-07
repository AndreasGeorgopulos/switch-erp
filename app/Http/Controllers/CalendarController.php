<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarController extends Controller
{
	/**
	 * @return Factory|Application|View
	 */
	public function index()
	{
		//$events = $this->getVacationEvents();

		return view('calendar.index'/*, [
			'events' => $events,
		]*/);
	}

	/**
	 * @param Request $request
	 * @return JsonResponse
	 */
	public function ajaxGetCalendarEvents(Request $request): JsonResponse
	{
		$events = $this->getVacationEvents();

		return response()->json(['events' => $events]);
	}

	/**
	 * @return array
	 */
	private function getVacationEvents(): array
	{
		$models = Vacation::orderBy('begin_date', 'asc')->get();

		return $models->map(function ($item) {
			return [
				'id' => 'vacation-' . $item->id,
				'title' => $this->getVacationTitle($item),
				'start' => $item->begin_date,
				'end' => Carbon::parse($item->end_date)->addDay()->format('Y-m-d'),
				'classNames' => 'text-center vacation vacation-status-' . $item->status,
				'extendedProps' => [
					'notice' => $item->notice,
					'is_deletable' => (int) $item->isDeletable(),
					'is_approvable' => (int) $item->isApprovable(),
					'is_rejectable' => (int) $item->isRejectable(),
				],
			];
		})->toArray();
	}

	/**
	 * @param Vacation $vacation
	 * @return string
	 */
	private function getVacationTitle(Vacation $vacation): string
	{
		$name = $vacation->user->name;
		$beginDate = Carbon::parse($vacation->begin_date)->format('Y.m.d');
		$endDate = Carbon::parse($vacation->end_date)->format('Y.m.d');

		if ($vacation->status === Vacation::STATUS_REQUESTED) {
			return "$name szabadság kérelme $beginDate-$endDate között";
		} elseif ($vacation->status === Vacation::STATUS_APPROVED) {
			return "$name szabadságon $beginDate-$endDate között";
		} elseif ($vacation->status === Vacation::STATUS_REJECTED) {
			return "$name szabadság kérelme elutasítva";
		}

		return '';
	}
}
