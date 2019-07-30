<?php $messages = $this->messenger->getMessages();
if (!empty($messages)): foreach ($messages as $message): ?>
    <p class="message <?= $message[1] ?>"><?= $message[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a>
    </p>
<?php endforeach;endif; ?>


