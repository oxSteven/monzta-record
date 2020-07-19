<?php

namespace Kiryi\MonztaRecord\Helper;

use Kiryi\MonztaRecord\Model\Record;
use Kiryi\Flaryi\Client as Flaryi;
use Exception;

class CacheHandler extends Exception
{
	const CACHEFILE = __DIR__ . '/../../cache/records.json';
	const CACHELIFETIME = 60 * 60 * 24;
	const EXECUTIONTIMELIMIT = 60 * 10;

	private ?Flaryi $client = null;
	
	public function __construct()
	{
		$this->client = new Flaryi();
	}

    public function getRecords(): array
    {
		if (file_exists($this::CACHEFILE) === false) {
			set_time_limit($this::EXECUTIONTIMELIMIT);
			$this->fetchRecords(true);
			return $this->readCache();
		} elseif (filemtime($this::CACHEFILE) < (time() - $this::CACHELIFETIME)) {
			$this->fetchRecords();
			return $this->readCache();
		} else {
			return $this->readCache();
		}
	}

	private function readCache(): array
	{
		return json_decode(file_get_contents($this::CACHEFILE));
	}

	private function writeCache(array $newRecords, bool $update = true): void
	{
		if ($update === true) {
			$cachedRecords = $this->readCache();
			
			foreach ($cachedRecords as $key => $cachedRecord) {
				foreach ($newRecords as $newRecord) {
					if ($cachedRecord->id == $newRecord['id']) {
						$cachedRecords[$key] = $newRecord;
					}
				}
			}
		} else {
			$cachedRecords = $newRecords;
		}
		
		file_put_contents($this::CACHEFILE, json_encode($cachedRecords));
	}

	private function fetchRecords(bool $fetchAll = false): void
    {
		$fields = ['lastPostedAt', 'firstPost', 'tags'];
		$filter = 'tag:record -is:sticky';
		
		$records = [];

		$response = $this->client->call('Discussion')->getAll($fields, $filter);

		foreach ($response as $discussion) {
			$tags = [];

			foreach ($discussion->relationships->tags->data as $tag) {
				$tags[] = $tag->id;
			}

			$records[] = [
				'id' => $discussion->id,
				'updated' => date('U', strtotime($discussion->attributes->lastPostedAt)),
				'postId' => $discussion->relationships->firstPost->data->id,
				'tags' => $tags,
			];
		}

		if ($fetchAll === true) {
			$this->writeCache($this->fetchAllRecords($records), false);
		} else {
			$this->writeCache($this->updateNewRecords($records));
		}
	}

	private function updateNewRecords(array $records): array
	{
		$newRecords = [];

		foreach ($records as $record) {
			if ($record['updated'] > filemtime($this::CACHEFILE)) {
				$record['content'] = $this->fetchUpdatedRecord($record['postId']);
				$newRecord = new Record($record);
				$newRecords[] = $newRecord->getProperties();
			}
		}

		return $newRecords;
	}

	private function fetchAllRecords(array $records): array
	{
		$newRecords = [];

		foreach ($records as $record) {
			$record['content'] = $this->fetchUpdatedRecord($record['postId']);
			$newRecord = new Record($record);
			$newRecords[] = $newRecord->getProperties();
		}

		return $newRecords;
	}

	private function fetchUpdatedRecord(int $id): string
	{
		$fields = ['content'];
			
		$record = $this->client->call('Post')->get($id, $fields);
		
		return $record->data->attributes->content;
	}
}
