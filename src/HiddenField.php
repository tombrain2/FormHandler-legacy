<?php

/**
 * Copyright (C) 2015 FormHandler
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301  USA
 */

/**
 * @deprecated Use \FormHandler\Field\Hidden instead
 */
class HiddenField extends \FormHandler\Field\Hidden
{
    public static function set(\FormHandler\FormHandler $form, $name, $validator = null)
    {
        return parent::set($form, $name)
            ->setValidator(FormHandler::parseValidator($validator));
    }

    public function setValidator($validator = null)
    {
        if(count($this->getValidators()) === 0
            && $validator instanceof FormHandler\Validator\FunctionCallable
            && is_array($validator->getCallable()))
        {
            $callable = $validator->getCallable();

            //detect if it is an optional validator
            if($callable[0] instanceof Validator
                && substr($callable[1], 0, 1) !== '_')
            {
                parent::setValidator(new \FormHandler\Validator\NotEmpty());
            }
        }

        return parent::setValidator(FormHandler::parseValidator($validator));
    }
}