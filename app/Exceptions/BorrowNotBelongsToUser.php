<?php

namespace App\Exceptions;

use Exception;

class BorrowNotBelongsToUser extends Exception
{
      public function render()
      {
            return [
                  'errors' => 'Borrow not belongs to user!'
            ];
      }
}
