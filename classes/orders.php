<?php
	/**
	*	-D- Класс @orders - работа с заказами;
	*/
	class orders {
		/**
		 * -D - Локальный защищённый экземпляр объекта БД;
		 * -V- {db} @db: БД;
		 */
		private $db = NULL;
		/**
		 * -D, Method- Метод выполняющий валидацию ввода полей информации о заказе и добавляющий её в Б/Д;
		 * -V- {String} ;
		 * -R- Array(
		 	''	=> ()//
			''	=> (bool),		// true - успешное подключение, false - есть ошибки;
			''	=> array(),		// массив ошибок в строчном виде;
		 );
		 */
		public function addOrder( $firstName, $surname, $city, $address, $phone, $itemsArray/*, $summa*/ ) {
			$success = false;
			$orderId = NULL;
			$errors = array();

			$firstName = trim( $firstName );
			$surname = trim( $surname );
			$city = trim( $city );
			$address = trim( $address );
			$phone = trim( $phone );

			if( empty( $firstName )) {
				$errors[] = "Укажите имя!";
			} elseif ( mb_strlen( $firstName, 'utf-8' ) > 32 ) {
				$errors[] = "Имя должно быть не более 32 символов!";
			}

			if( empty( $surname )) {
				$errors[] = "Укажите фамилию!";
			} elseif ( mb_strlen( $surname, 'utf-8' ) > 32 ) {
				$errors[] = "Фамилия должна быть не более 32 символов!";
			}

			if( empty( $phone )) {
				$errors[] = "Укажите номер телефона!";
			}

			if( count( $errors ) == 0 ) {
				$query = '
					INSERT INTO
						orders (
							`client_firstname`,
							`client_surname`,
							`city`,
							`address`,
							`phone`,
							`order_time`,
							`order_status`
						)
					VALUES (
						"'.$this->db->realEscape( $firstName ).'",
						"'.$this->db->realEscape( $surname ).'",
						"'.$this->db->realEscape( $city ).'",
						"'.$this->db->realEscape( $address ).'",
						"'.$this->db->realEscape( $phone ).'",
						CURRENT_TIMESTAMP(),
						"in_progress"
					);
				';
				$res = $this->db->query( $query, 'insert' );
				if ( $res['success'] ) {

					$orderId = $res['id'];
					for ( $i = 0; $i < count( $itemsArray ); $i++ ) {
						$query = '
							INSERT INTO
								orders_products (
									`order_id`,
									`prod_id`
								)
							VALUES (
								'.$orderId.',
								'.$itemsArray[ $i ].'
							);
						';
						$res = $this->db->query( $query, 'insert' );
						if ( $res['success'] ) {
							$success = true;
						} else {
							$errors = $res['errors'];
							break;
						}
					}
				} else {
					$errors = $res['errors'];
				}
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors,
				'id'		=> $orderId
			);
		}
 		/**
		*	-D- @getOrdersList - Метод получения списка заказов из Б/Д;
		*
		*/
		public function getOrdersList ( $pnum, $limit, $whereString ) {
			$success = false;
			$ordersArr = NULL;
			$errors = array();
			$entireOrder = array();
			$ordersList = array();

			$pStart = ($pnum - 1) * $limit;

			$query = '
				SELECT
					`id`,
					`client_firstname`,
					`client_surname`,
					`city`,
					`address`,
					`phone`,
					`order_time`,
					`order_status`
				FROM
					`orders`
					'.$whereString.'
				ORDER BY
					`order_time`
				DESC
				LIMIT
					'.$pStart.',
					'.$limit.';
			';
			//print_r($query);
			$res = $this->db->query( $query, 'select' );
			if ( $res['success'] ) {
				$success = true;
				$ordersArr = $res['resultArr'];
				foreach ( $ordersArr as $orderInstance) {
					$query = '
						SELECT
							i.id,
							i.title,
							i.cost
						FROM
							items AS i
						JOIN
							orders_products AS op
						ON
							i.id = op.prod_id
						WHERE
							op.order_id = '.$orderInstance['id'].';
					';
					$res = $this->db->query( $query, 'select' );
					if ( $res['success'] ) {
						$success = true;
						$itemsArr = $res['resultArr'];
						$sum = 0;
						foreach ( $itemsArr as $item ) {
							$sum += $item['cost'];
						}
						$entireOrder['orderInstance'] = $orderInstance;
						$entireOrder['itemsArr'] = $itemsArr;
						$entireOrder['summa'] = $sum;
						$ordersList[] = $entireOrder;
					} else {
						$errors = $res['errors'];
						$success = false;
						break;
					}
				}
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'		=> $success,
				'ordersList'	=> $ordersList,
				'errors'		=> $errors
			);
		}
		/**
		*	-D- @setOrderStatus - Метод установки(изменения) статуса заказа;
		*
		*/
		public function setOrderStatus ( $orderId, $newStatus ) {
			$success = false;
			$errors = array();

			$query = '
				UPDATE
					`orders`
				SET
					`order_status` = "'.$newStatus.'"
				WHERE
					`id`='.$orderId.';
			';

			$res = $this->db->query($query, 'update');
			if ( $res['success'] ) {
				$success = true;
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors
			);
		}
		/**
		 * -D, Method- Экземпляр объекта БД;
		 * -V- {db} @db: БД;
		 */
		public function setDB( $db ) {
			$this->db = $db;
		}
		/**
		 * -D, Method- Получение количества страниц списка заказов;
		 * -V- {int} @limit: количество заказов отображаемых на одной странице;
		 * -R- {int} @limit: Количество страниц;
		 * -R- {boolean} @limit = false: ошибки при выполнении;
		 */
		public function getCountPages( $limit, $whereString ) {
			$query = '
				SELECT
					COUNT(*) AS pcount
				FROM
					`orders`
				 '.$whereString.'
				;
			';
			$res = $this->db->query( $query, 'select_row' );
			if ( $res['success'] ) {
				$countPages = intval( $res['resultArr']['pcount'] );
					return intval( ceil( $countPages / $limit ));
			} else {
				return false;
			}
		}
	}
?>