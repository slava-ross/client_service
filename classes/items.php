<?php
	/**
	*	-D- Класс @items - работа с товарами;
	*/
	class items {
		/**
		 * -D - Локальный защищённый экземпляр объекта БД;
		 * -V- {db} @db: БД;
		 */
		private $db = NULL;
		/**
		 * -D, Method- Метод выполняющий валидацию ввода полей информации о товаре и добавляющий её в Б/Д;
		 * -V- {String} ;
		 * -R- Array(
		 	''	=> ()//
			''	=> (bool),		// true - успешное подключение, false - есть ошибки;
			''	=> array(),		// массив ошибок в строчном виде;
		 );
		 */
		public function addItem ( $title, $description, $dateCreated, $cost, $amount, $fileArray ) {
			$success = false;
			$id = NULL;
			$errors = array();

			$title = trim( $title );
			$dateCreated = trim( $dateCreated );
			$cost = trim( $cost );
			$amount = trim( $amount );

			if( empty( $title )) {
				$errors[] = "Укажите наименование товара!";
			} elseif ( mb_strlen( $title, 'utf-8' ) > 50 ) {
				$errors[] = "Наименование должно быть не более 50 символов!";
			}

			if( empty( $dateCreated )) {
				$errors[] = "Укажите дату поступления товара!";
			} elseif ( !preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/ui', $dateCreated )) {
				$errors[] = "Дата должна быть в формате: 00.00.0000";
			} else {
				$dateCreated = date('Y-m-d H:i:s', strtotime( $dateCreated ));
			}

			if( empty( $cost )) {
				$errors[] = "Укажите стоимость товара!";
			} elseif ( !preg_match( '/\d{1,13}[,\.]?(\d{1,2})?/u', $cost )) {
				$errors[] = "Стоимость должна быть в формате: 0000; 0000.00; 0000,00!";
			}

			if( empty( $amount )) {
				$errors[] = "Укажите количество товара!";
			}

			foreach ( $fileArray["error"] as $key => $error ) {
				if ( $error != UPLOAD_ERR_OK ) {
				$errors[] = "Не выбран файл или ошибка загрузки файла!";
				}
			}

			if( count( $errors ) == 0 ) {
				$query = '
					INSERT INTO
						items (
							`title`,
							`description`,
							`date-created`,
							`cost`,
							`amount`
						)
					VALUES (
						"'.$this->db->realEscape( $title ).'",
						"'.$this->db->realEscape( $description ).'",
						"'.$dateCreated.'","'.$this->db->realEscape( $cost ).'",
						'.$amount.'
					);
				';
				$res = $this->db->query($query, 'insert');
				if ( $res['success'] ) {
					$success = true;
					$id = $res['id'];

					$uploadsDir = "uploads";
					foreach ( $fileArray["tmp_name"] as $key => $tmpName ) {
						$fileName = basename( $fileArray["name"][$key] );
						$path_info = pathinfo( $fileName );
						$fileExten = $path_info['extension'];
						$newFileName = uniqid('photo_').'.'.$fileExten;
						// print( 'TMP: '.$tmpName.' NAME: '.$fileName.' EXT: '.$fileExten.' NEW: '.$newFileName);
						move_uploaded_file( $tmpName, "$uploadsDir/$newFileName" );
						$query = '
							INSERT INTO
								files (
									`item-id`,
									`name`,
									`orig-name`
								)
							VALUES (
								"'.$id.'",
								"'.$this->db->realEscape( $newFileName ).'",
								"'.$this->db->realEscape( $fileName ).'"
							);
						';
						$res = $this->db->query($query, 'insert');
					}
				} else {
					$errors = $res['errors'];
				}
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors,
				'id'		=> $id
			);
		}
		/**
		 * -D, Method- Изменение информации о товаре;
		 * -V- {String} @itemId: идентификатор товара;
		 * -V- {String} @title: наименование товара;
		 * -V- {String} @description: описание товара;
		 * -V- {String} @dateCreated: дата создания новости;
		 * -V- {String} @cost: стоимость товара;
		 * -V- {String} @amount: количество товара;
		 * -R- Array(
			'success'	=> (bool),		// true - успешное выполнение, false - есть ошибки;
			'errors'	=> array(),		// массив ошибок в строчном виде;
		 );
		 */
		public function editItem ( $itemId, $title, $description, $dateCreated, $cost, $amount, $fileArray ) {
			$success = false;
			$errors = array();

			$title = trim( $title );
			$dateCreated = trim( $dateCreated );
			$cost = trim( $cost );

			if( empty( $title )) {
				$errors[] = "Укажите наименование товара!";
			} elseif ( mb_strlen( $title, 'utf-8' ) > 50 ) {
				$errors[] = "Наименование должно быть не более 50 символов!";
			}

			if( empty( $dateCreated )) {
				$errors[] = "Укажите дату поступления товара!";
			} elseif ( !preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/ui', $dateCreated )) {
				$errors[] = "Дата должна быть в формате: 00.00.0000";
			} else {
				$dateCreated = date('Y-m-d H:i:s', strtotime( $dateCreated ));
			}

			if( empty( $cost )) {
				$errors[] = "Укажите стоимость товара!";
			} elseif ( !preg_match( '/\d{1,13}[,\.]?(\d{1,2})?/u', $cost )) {
				$errors[] = "Стоимость должна быть в формате: 0000; 0000.00; 0000,00!";
			}

			if( empty( $amount )) {
				$errors[] = "Укажите количество товара!";
			}

			if( count( $errors ) == 0 ) {
				$query = '
					UPDATE
						`items`
					SET
						`title`= "'.$this->db->realEscape( $title ).'",
						`description`="'.$this->db->realEscape( $description ).'",
						`date-created`="'.$dateCreated.'",
						`cost`="'.$this->db->realEscape( $cost ).'",
						`amount`='.$amount.'
					WHERE
						`id`='.$itemId.';
				';

				$res = $this->db->query($query, 'update');
				if ( $res['success'] ) {
					$success = true;
					$uploadsDir = "uploads";
					foreach ( $fileArray["error"] as $key => $error ) {
						if ( $error == UPLOAD_ERR_OK ) {
							$fileName = basename( $fileArray["name"][$key] );
							$path_info = pathinfo( $fileName );
							$fileExten = $path_info['extension'];
							$newFileName = uniqid('photo_').'.'.$fileExten;
							move_uploaded_file( $fileArray["tmp_name"][$key], "$uploadsDir/$newFileName" );
							$query = '
								INSERT INTO
									files (
										`item-id`,
										`name`,
										`orig-name`
									)
								VALUES (
									"'.$itemId.'",
									"'.$this->db->realEscape( $newFileName ).'",
									"'.$this->db->realEscape( $fileName ).'"
								);
							';
							$res = $this->db->query($query, 'insert');
						}
					}
				} else {
					$errors = $res['errors'];
				}
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors
			);
		}
		/**
		*	-D- @delItem - Метод удаления товара из БД;
		*/
		public function delItem ( $itemId ) {
			$success = false;
			$errors = array();
			$query = '
				DELETE
				FROM
					`items`
				WHERE
					`id` = '.$itemId.';
			';
			$res = $this->db->query( $query, 'delete' );
			if ( $res['success'] ) {
				$query = '
					DELETE
					FROM
						`files`
					WHERE
						`item-id` = '.$itemId.';
				';
				$res = $this->db->query( $query, 'delete' );
				if ( $res['success'] ) {
					$success = true;
				} else {
					$errors = $res['errors'];
				}
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors
			);
		}
		/**
		*	-D- @delImage - Метод удаления фото товара;
		*/
		public function delImage ( $fileId, $fileName ) {
			$success = false;
			$errors = array();

			$query = '
				DELETE
				FROM
					`files`
				WHERE
					`id` = '.$fileId.';
			';
			$res = $this->db->query( $query, 'delete' );
			if ( $res['success'] ) {
				if ( unlink( 'uploads/'.$fileName )) {
					$success = true;
				} else {
					$errors[] = 'Ошибка при удалении файла!';
				}
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'	=> $success,
				'errors'	=> $errors
			);
		}
 		/**
		*	-D- @getItem - Метод получения информации об одном товаре;
		*/
		public function getItem ( $itemId ) {
			$success = false;
			$itemArray = array();
			$filesArray = array();
			$errors = array();

			$query = '
				SELECT
					`title`,
					`description`,
					`date-created`  AS item_date,
					`cost`,
					`amount`
				FROM
					`items`
				WHERE
					`id` = '.$itemId.';
			';
			$res = $this->db->query( $query, 'select_row' );
			if ( $res['success'] ) {
				$itemArray = $res['resultArr'];
				$query = '
					SELECT
						`id`,
						`name`
					FROM
						`files`
					WHERE
						`item-id` = '.$itemId.';
				';
				$res = $this->db->query( $query, 'select' );
				if ( $res['success'] ) {
					$success = true;
					$filesArray = $res['resultArr'];
				} else {
					$errors = $res['errors'];
				}
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'	=> $success,
				'itemArr'	=> $itemArray,
				'filesArr'	=> $filesArray,
				'errors'	=> $errors
			);
		}
 		/**
		*	-D- @getItemsList - Метод получения списка товаров из Б/Д;
		*
		*/
		public function getItemsList ( $pnum, $limit ) {
			$success = false;
			$itemsArr = NULL;
			$errors = array();

			$pStart = ($pnum - 1) * $limit;

			$query = '
				SELECT
					`id`,
					`title`,
					`description`,
					`date-created`,
					`cost`,
					`amount`
				FROM
					`items`
				LIMIT '.$pStart.','.$limit.';
			';
			$res = $this->db->query( $query, 'select' );
			if ( $res['success'] ) {
				$success = true;
				$itemsArr = $res['resultArr'];
			} else {
				$errors = $res['errors'];
			}
			return array(
				'success'	=> $success,
				'itemsArr'	=> $itemsArr,
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
		 * -D, Method- Получение количества страниц списка товаров;
		 * -V- {int} @limit: количество товаров отображаемых на одной странице;
		 * -R- {int} @limit: Количество страниц;
		 * -R- {boolean} @limit = false: ошибки при выполнении;
		 */
		public function getCountPages( $limit ) {
			$query = '
				SELECT
					COUNT(*) as pcount
				FROM
					`items`;
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