<?php

/** ====================================================================
 * BSD License
 *
 * Copyright (c) 2011, ntrp
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - Neither the name of the GreenHub nor the names of its contributors
 *   may be used to endorse or promote products derived from this software
 *   without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO,
 * THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR
 * CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
 * EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
 * OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
 * WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
 * ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/
namespace qoo\model;

abstract class MongoActiveConnections 
{
    private static $_db_handler = array();

    public function getHandler($mcinfo) 
	{
        $connHASH = md5($mcinfo->user . $mcinfo->pwd . $mcinfo->host . $mcinfo->dbname);

        if (!array_key_exists($connHASH, self::$_db_handler) || self::$_db_handler[$connHASH] == null)
		{
            try 
			{
                $connStr = 'mongodb://' . $mcinfo->user . ':' . $mcinfo->pwd . '@' . $mcinfo->host . '/' . $mcinfo->dbname;

				if ($mcinfo->options == null)
                	$mongo = new \Mongo($connStr);
				else
                	$mongo = new \Mongo($connStr, $mcinfo->options);

                self::$_db_handler[$connHASH] = $mongo->selectDB($mcinfo->dbname);
            } catch (MongoConnectionException $e) 
			{
                self::$_db_handler[$connHASH] = null;
                throw new \qoo\core\Exception('Cannot connect to mongodb url: ' . $host . '/' . $dbname);
            }
        }
        return self::$_db_handler[$connHASH];
    }
}

?>
