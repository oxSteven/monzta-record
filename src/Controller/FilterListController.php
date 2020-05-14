<?php

namespace Kiryi\MonztaRecord\Controller;

use Kiryi\MonztaRecord\Helper\FilterListReader;
use Kiryi\Viewyi\Engine as Viewyi;
use Kiryi\Inyi\Reader as Inyi;
use Kiryi\Pathyi\Formatter as Pathyi;

class FilterListController
{
	private array $activeFilters = [];
	private ?Pathyi $pathyi = null;

	public function render(Viewyi $viewyi, array $params): void
	{
		$this->activeFilters = $params;
		$this->pathyi = new Pathyi();

		$viewyi->assign('filterList', $this->getExtendedFilterList());
		$viewyi->render('filterList');
	}

	private function getExtendedFilterList(): array
	{
		$simpleFilterList = (new FilterListReader())->read();
		$extendedFilterList = [];

		foreach ($simpleFilterList as $filterGroupName => $filterGroup) {
			foreach ($filterGroup as $filter) {
				$extendedFilterList[ucfirst($filterGroupName)][] = [
					'name' => $filter->name,
					'url' => $this->getFilterUrl(strtolower($filter->ident)),
					'active' => $this->getFilterActiveStatus($filter->ident),
				];
			}
		}
		
		return $extendedFilterList;
	}

	private function getFilterUrl(string $filter): string
	{
		$requestUri = $this->getRequestUri();

		if ($this->getFilterActiveStatus($filter) === true) {
			$requestUri = str_replace('/' . $filter . '/', '/', $requestUri);
			$requestUri = str_replace('//', '/', $requestUri);
		} else {
			$requestUri .= $filter;
		}

		return $this->pathyi->format($requestUri);
	}

	private function getFilterActiveStatus(string $filter): bool
	{
		if (in_array($filter, $this->activeFilters) === true) {
			return true;
		} else {
			return false;
		}
	}

	private function getRequestUri(): string
	{
		$uri = $this->pathyi->format($_SERVER['REQUEST_URI'], true, true);

		if (strpos($uri, '/list') === false) {
			$uri = '/list/';
		}

		/*  !!! TESTING ONLY !!! */
		$uri =  str_replace('monzta-record/public/', '', $uri);
		/*  !!! TESTING ONLY END !!! */

		return $uri;
	}
}
