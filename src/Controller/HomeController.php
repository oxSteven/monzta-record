<?php

namespace Kiryi\MonztaRecord\Controller;

use Kiryi\Routyi\EndpointInterface;
use Kiryi\Pagyi\Builder as Pagyi;
use Kiryi\Viewyi\Engine as Viewyi;

class HomeController implements EndpointInterface
{
	public function run(array $params)
	{
		$viewyi = new Viewyi();

		$pagyi = new Pagyi('config/viewyi.ini');
		$content = $pagyi->build('asset/json/homeHeader.json', 'asset/md');

		$viewyi->assign('content', $content);
		$viewyi->render('header');

		(new FilterListController())->render($viewyi, $params);

		$pagyi = new Pagyi('config/viewyi.ini');
		$content = $pagyi->build('asset/json/homeGuidelines.json', 'asset/md');

		$viewyi->assign('content', $content);
		$viewyi->render('content');
		
		$viewyi->render('footer');
		$viewyi->display('head', 'MONZTArecord');
	}
}
