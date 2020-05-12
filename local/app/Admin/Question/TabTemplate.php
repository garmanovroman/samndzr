<tr>
  <td width="20%">Логическое условие показа</td>
  <td>
    <div class="properties-input" data-properties-input='<?= $this->autocomplete; ?>'>
      <input type="hidden" name="RULES" value="<?= $this->question ? $this->question['RULES_TEXT'] : null; ?>">
      <ul></ul>
    </div>
  </td>
</tr>
<tr>
  <td width="20%">
    <em>Операторы</em>
  </td>
  <td>
    <? $isFirst = true; ?>
    <? foreach ($this->operators as $opertator) : ?>
      <? if (!$isFirst) : ?> , <? endif; ?>
      <a href="#" data-properties-paste=""><?= $opertator['UF_NAME']; ?></a>
      <? $isFirst = false; ?>
    <? endforeach; ?>
    , <em>также можно использовать круглые скобки для группировки.</em>
  </td>
</tr>
<? foreach ($this->properties as $property) : ?>
  <tr>
    <td width="20%">
      <em><?= $property['UF_NAME']; ?></em>
    </td>
    <td>
      <? $isFirst = true; ?>
      <? foreach ($property->values as $value) : ?>
        <? if (!$isFirst) : ?> , <? endif; ?>
        <a href="#" data-properties-paste=""><?= $value['UF_VALUE']; ?></a>
        <? $isFirst = false; ?>
      <? endforeach; ?>
    </td>
  </tr>
<? endforeach; ?>