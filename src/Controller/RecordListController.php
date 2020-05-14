<?php

namespace Kiryi\MonztaRecord\Controller;

use Kiryi\MonztaRecord\Helper\CacheHandler;
use Kiryi\MonztaRecord\Helper\FilterHandler;
use Kiryi\MonztaRecord\Helper\FilterListReader;
use Kiryi\Routyi\EndpointInterface;
use Kiryi\Pagyi\Builder as Pagyi;
use Kiryi\Viewyi\Engine as Viewyi;

class RecordListController implements EndpointInterface
{
	const SUBMITLINK = 'http://localhost/mztfrm/devforum-monzta-net/public/d/';
	//const DISCUSSIONLINK = 'https://forum.monzta.net/d/';

	private array $params = [];

	public function run(array $params)
	{
		$this->params = $params;

		$viewyi = new Viewyi();

		$pagyi = new Pagyi('config/viewyi.ini');
		$content = $pagyi->build('asset/json/listHeader.json', 'asset/md');

		$viewyi->assign('content', $content);
		$viewyi->render('header');
		
		(new FilterListController())->render($viewyi, $this->params);

		$viewyi->assign('submitLink', $this::SUBMITLINK);
		$viewyi->assign('records', $this->filterRecords());
		$viewyi->render('recordList');
		$viewyi->render('footer');
		$viewyi->display('head', 'Record List - MONZTArecord');
	}

	private function filterRecords(): array
	{
		$filterHandler = new FilterHandler();
		$currentFilterList = $this->getCurrentFilters();
		$fullRecordList = (new CacheHandler)->getCachedData();
		$filteredRecordList = [];
		
		foreach ($fullRecordList as $record) {
			$match = false;

			foreach ($currentFilterList as $filterGroupName => $filterGroup) {
				$functionName = 'filter' . ucfirst($filterGroupName);

				foreach ($filterGroup as $filter) {
					if ($filterHandler->$functionName($filter, $record) === true) {
						$match = true;
						break;
					} else {
						$match = false;
					}
				}

				if ($match === false) {
					break;
				}
			}
		
			if ($match === true) {
				$filteredRecordList[] = $record;
			}
		}
		
		return $filteredRecordList;
	}

	private function getCurrentFilters(): array
	{
		$fullFilterList = (new FilterListReader())->read();
		$currentFilterList = [];

		foreach ($fullFilterList as $filterGroupName => $filterGroup) {
			foreach ($filterGroup as $filter) {
				if (in_array($filter->ident, $this->params)) {
					$currentFilterList[$filterGroupName][] = $filter->ident;
				}
			}
		}

		return $currentFilterList;
	}
}
