<?php

namespace Kiryi\MonztaRecord\Helper;

use Kiryi\MonztaRecord\Model\Record;
use Kiryi\Flaryi\Client as Flaryi;
use Exception;

class CacheHandler extends Exception
{
	const ERRORMSG = 'MONZTArecord DATA ERROR [Code %d]: Unable to receive data. Please inform administrator.';
	const CACHEFILE = __DIR__ . '/../../cache/records.json';
	const CACHEUPDATESCRIPT = __DIR__ . '/../../bin/updateCache.php';
	const CACHELIFETIME = 60 * 60 * 3;

	private ?Flaryi $client = null;
	
	public function __construct()
	{
		$this->client = new Flaryi();
	}

    public function getCachedData(): array
    {
		$cache = $this->readCache();

		return $cache->data;
	}

	public function verifyCacheLife(): void
	{
		if (file_exists($this::CACHEFILE) === false) {
			$this->updateCache();
		} else {
			$cache = $this->readCache();

			if (
				$cache->state->updating === false
				&& $cache->state->lastUpdateTimestamp + $this::CACHELIFETIME < time()
			) {
				$cache->state->updating = true;
				$this->writeCache($cache);
				
				$this->updateCache();
			}
		}
	}
	
	private function updateCache(): void
	{
		$time = time();

		$cacheData = [
			'state' => [
				'updating' => false,
				'lastUpdate' => date('Y-m-d H:i:s', $time),
				'lastUpdateTimestamp' => $time,
			],
			'data' => $this->getRecords(),
		];

		$this->writeCache((object) $cacheData);
	}
	
	private function readCache(): object
	{
		if (file_exists($this::CACHEFILE) === false) {
			throw new Exception(sprintf($this::ERRORMSG, 1));
		} else {
			$cache = json_decode(file_get_contents($this::CACHEFILE));

			if (count($cache->data) <= 0) {
				throw new Exception(sprintf($this::ERRORMSG, 2));
			} else {
				return $cache;
			}
		}
	}

	private function writeCache(object $cache): void
	{
		file_put_contents($this::CACHEFILE, json_encode($cache));
	}
    
    private function getRecords(): array
	{
		$records = [];
		$posts = $this->getPosts();

		foreach ($posts as $post) {
			$record = new Record($post);
			$records[] = $record->getProperties();
		}

		return $records;
	}

	private function getPosts(): array
	{
		$posts = [];
		$fields = ['content'];

		foreach ($this->getDiscussions() as $discussion) {			
			$post = $this->client->call('Post')->get($discussion['postId'], $fields);

			$posts[] = [
				'id' => $discussion['discussionId'],
				'content' => $post->data->attributes->content,
				'tags' => $discussion['tags'],
			];
		}
		
		return $posts;
	}

	private function getDiscussions(): array
    {
		$fields = ['firstPost', 'tags'];
        $filter = 'tag:record';

		$discussions = [];

		$response = $this->client->call('Discussion')->getAll($fields, $filter);

		foreach ($response as $discussion) {
			$tags = [];

			foreach ($discussion->relationships->tags->data as $tag) {
				$tags[] = $tag->id;
			}

			$discussions[] = [
				'discussionId' => $discussion->id,
				'postId' => $discussion->relationships->firstPost->data->id,
				'tags' => $tags,
			];
		}

		return $discussions;
	}
}
