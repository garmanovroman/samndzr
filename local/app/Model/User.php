<?php
namespace App\Model
{
  /**
   * Модель пользователя.
   */
  class User extends Base
  {
    /**
     * Таблица с пользователями.
     * @var string
     */
    protected $table = 'b_user';

    /**
     * Связанные объекты пользователя.
     * @return mixed
     */
    public function objects()
    {
      return $this->hasMany(
        'App\Model\Object',
        'UF_USER_ID'
      );
    }
  }
}