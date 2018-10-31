<?php
declare(strict_types=1);


/**
 * FullTextSearch - Full text search framework for Nextcloud
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Maxence Lange <maxence@artificial-owl.com>
 * @copyright 2018
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 */


namespace OCA\FullTextSearch\Db;


use OCA\FullTextSearch\Model\Tick;
use OCP\DB\QueryBuilder\IQueryBuilder;


/**
 * Class TickRequestBuilder
 *
 * @package OCA\FullTextSearch\Db
 */
class TickRequestBuilder extends CoreRequestBuilder {


	/**
	 * Base of the Sql Insert request
	 *
	 * @return IQueryBuilder
	 */
	protected function getTickInsertSql(): IQueryBuilder {
		$qb = $this->dbConnection->getQueryBuilder();
		$qb->insert(self::TABLE_TICKS);

		return $qb;
	}


	/**
	 * Base of the Sql Update request
	 *
	 * @return IQueryBuilder
	 */
	protected function getTickUpdateSql(): IQueryBuilder {
		$qb = $this->dbConnection->getQueryBuilder();
		$qb->update(self::TABLE_TICKS);

		return $qb;
	}


	/**
	 * Base of the Sql Select request for Shares
	 *
	 * @return IQueryBuilder
	 */
	protected function getTickSelectSql(): IQueryBuilder {
		$qb = $this->dbConnection->getQueryBuilder();

		/** @noinspection PhpMethodParametersCountMismatchInspection */
		$qb->select(
			't.id', 't.source', 't.data', 't.first_tick', 't.tick', 't.status', 't.action'
		)
		   ->from(self::TABLE_TICKS, 't');

		$this->defaultSelectAlias = 't';

		return $qb;
	}


	/**
	 * Base of the Sql Delete request
	 *
	 * @return IQueryBuilder
	 */
	protected function getTickDeleteSql(): IQueryBuilder {
		$qb = $this->dbConnection->getQueryBuilder();
		$qb->delete(self::TABLE_INDEXES);

		return $qb;
	}


	/**
	 * @param array $data
	 *
	 * @return Tick
	 */
	protected function parseTickSelectSql(array $data): Tick {
		$tick = new Tick($data['source'], $data['id']);
		$tick->setData(json_decode($data['data'], true))
			 ->setTick($data['tick'])
			 ->setFirstTick($data['first_tick'])
			 ->setStatus($data['status'])
			 ->setAction($data['action']);

		return $tick;
	}

}
