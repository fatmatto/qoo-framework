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

/**
 *
 *
 * @author ntrp
 */
abstract class MongoBaseDAO
{
	protected $db_handler;
	protected $cll_handler;

	public function __construct($mongoCInfo, $cName) {
		$this->db_handler = DBConnectionFactory::getDBHandler('mongo', $mongoCInfo);        
		$this->cll_handler = $this->db_handler->selectCollection($cName);
	}	

	protected function insert($doc, $options= null) {

		return $this->cll_handler->insert($doc, $options);
	}

	protected function update($query, $newdoc, $options = null) {

		if (isset($options))
		{
			return $this->cll_handler->update($query, $fields, $options);
		}
		return $this->cll_handler->update($query, $fields);
	}

	protected function find($query = null, $fields = null) {

		if (isset($query)) {
			if (isset($fields)) {
				return $this->cll_handler->find($query, $fields);
			}
			return $this->cll_handler->find($query);
		}
		return $this->cll_handler->find();
	}

	protected function remove($query = null, $options = null) {

		if (isset($options))
		{
			return $this->cll_handler->remove($query, $options);
		}
		return $this->cll_handler->remove($query);
		}


#    protected function insert($doc, $options= null) {

#        if (isset($options)) 
#		{
#            return $this->cll_handler->insert($doc, $pptions);
#        }
#        return $this->cll_handler->insert($doc);
#    }

#    protected function update($query, $newdoc, $options = null) {

#		if (isset($options))
#		{
#        	return $this->cll_handler->update($query, $fields, $options);
#		}
#       	return $this->cll_handler->update($query, $fields);
#    }

#    protected function find($query = null, $fields = null) {

#        if (isset($query)) {
#            if (isset($fields)) {
#                return $this->cll_handler->find($query, $fields);
#            }
#            return $this->cll_handler->find($query);
#        }
#        return $this->cll_handler->find();
#    }

#    protected function remove($query = null, $options = null) {

#		if (isset($options))
#		{
#        	return $this->cll_handler->remove($query, $options);
#		}
#       	return $this->cll_handler->remove($query);
#    }

}
?>
