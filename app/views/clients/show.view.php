<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-body"> اسم العميل : <?= $client->Name ?> </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <p> العنوان : <?= $client->Address ?> </p>
            <p> الهاتف : <?= $client->PhoneNumber ?> </p>
            <p> الرصيد : <?= $client->balance ?> </p>
            <p> عدد الاقساط : <?= $client->protracts->cost ?> </p>
            <p> قيمة الاقساط : <?= $client->protracts->total ?> </p>
            <p> عدد الفواتير : <?= $client->invoicenumber->invoicenumber ?> </p>
        </div>
    </div>
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                        الاقساط </a>
                </h4>
            </div>
            <div id="collapse1" class="panel-collapse collapse in">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th> رقم</th>
                            <th>رقم الفاتوره</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>دفع</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $number = 1;
                        $sum = 0;
                        if ($protracts != false)
                            foreach ($protracts as $protract) { ?>
                                <tr class="<?= $this->getprotractclass($protract->is_payed, $protract->date) ?>">
                                    <td><?= $number ?></td>
                                    <td><?= $protract->billId ?></td>
                                    <td><?= $protract->cost ?></td>
                                    <td><?= $protract->date ?></td>
                                    <td>
                                        <?php if ($protract->is_payed == 1) { ?>
                                            <?= $protract->date ?> تم الدفع
                                        <?php } else { ?>
                                            <a class="btn btn-default pay_protract"
                                               data-id="<?= $protract->protractId ?>"
                                               data-client="<?= $protract->ClientId ?>"
                                               data-invouce="<?= $protract->billId ?>"> دفع الان </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php $number = $number + 1;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                        القواتير </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>الفاتورة رقم</th>
                            <th>حالة</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>المدفع</th>
                            <th>الباقى</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($invoices != false) foreach ($invoices as $invoice) { ?>
                            <tr>
                                <td><a href="/sales/show/<?= $invoice->InvoiceId ?>"><?= $invoice->InvoiceId ?></a></td>
                                <?php if ($invoice->PaymentStatus == 2) { ?>
                                    <td> قسط</td>
                                    <td> من <?= $invoice->Created ?>  </td>
                                    <td> عدد <?= $invoice->protracts->cost ?>  </td>
                                    <td> قيمه <?= $invoice->protracts->total / $invoice->protracts->cost ?>  </td>

                                <?php } elseif ($invoice->PaymentStatus == 1) { ?>
                                    <td> تسديد <?= $invoice->payed ?> </td>
                                    <td> من</td>
                                    <td> <?= $invoice->oldbalance ?></td>
                                    <td> الى</td>
                                    <td><?= ($invoice->oldbalance + $invoice->cost) - $invoice->payed ?></td>

                                <?php } else { ?>
                                    <td> شراء</td>
                                    <td> <?= $invoice->cost ?>   </td>
                                    <td> : القديم <?= $invoice->oldbalance ?></td>
                                    <td> المدفوع: <?= $invoice->payed ?> </td>

                                    <td><?= ($invoice->oldbalance + $invoice->cost) - $invoice->payed ?></td>
                                <?php } ?>

                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                        Collapsible Group 3</a>
                </h4>
            </div>
            <div id="collapse3" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>الفاتورة رقم</th>
                            <th>المبلغ</th>
                            <th>حالة</th>
                            <th>التاريخ</th>
                            <th>المدفع</th>
                            <th>الباقى</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>25</td>
                            <td>2500</td>
                            <td>قسط</td>
                            <td>قسط</td>
                            <td>قسط</td>
                            <td>قسط</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>