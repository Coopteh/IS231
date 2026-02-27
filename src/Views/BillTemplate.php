<?php

namespace App\Views;

use App\Views\BaseTemplate;

class BillTemplate extends BaseTemplate
{
    public function getBillTemplate($rows): string
    {
        global $user_name, $user_role;
        $template = parent::getBaseTemplate();
        $str = '';
        $str .= <<<END
        <div class="row">
            <div class="col-md-10 offset-md-1">
            <h3>Учёт Счетов</h3>
        END;

        if ($user_role == 'Поставщик') {
            $str .= <<<END
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Счёт</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Поставщик</th>
                    <th scope="col">Отдел</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
            END;
        } else {
            $str .= <<<END
            <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Счёт</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Стоимость</th>
                    <th scope="col">Поставщик</th>
                    <th scope="col">Отдел</th>
                    <th scope="col">Статус</th>
                    <th scope="col text-end">Операции</th>
                </tr>
            </thead>
            <tbody>
            END;
        }

        foreach ($rows as $row) {
            $mydate = mb_substr($row['date_bill'], 0, 10);
            $str .= <<<LINE
                <tr>
            <td>{$row['id_bill']}</td>
            <td>{$mydate}</td>
            <td>{$row['price']}</td>
            <td>{$row['fio']}</td>
            <td>{$row['group_name']}</td>
            <td>{$row['status']}</td>
            LINE;
            // проверка роли для операций изменения и удаления
            if ($user_role == 'Бухгалтер') {
                $str .= <<<LINE2
                <td>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                    <form action="/edit_record" method="POST">
                        <input type="hidden" name="id_bill" value="{$row['id_bill']}">
                        <button type="submit" class="btn btn-primary btn-sm">Изменить</button>
                    </form>
                    <form action="/delete_record" method="POST">
                        <input type="hidden" name="id_bill" value="{$row['id_bill']}">
                        <button type="submit" class="btn btn-primary btn-sm">Удалить</button>
                    </form>
                    </div>
                </td>
                LINE2;
            }
            $str .= "</tr>";
        }
        $str .= "</tbody></table>";

        // проверка роли для операции добавления записи
        if ($user_role == 'Бухгалтер') {
            $str .= <<<ADD
            <form action="/add_record" method="POST">
                <button type="submit" class="btn btn-primary">Добавить запись</button>
            </form>
            ADD;
        }
        $str .= '</div></div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>';

        $resultTemplate =  sprintf($template, 'Учёт счетов', $str);
        return $resultTemplate;
    }

    public function getFormTemplate($row, $clients)
    {
        $template = parent::getBaseTemplate();
        $str = '';
        if ($row) {
            $title = "Изменение счета";
            $fromUrl = "/edit_record";
            $btnTitle = "Сохранить";
            $valueDateBill = mb_substr($row['date_bill'], 0, 10);
            $billValue = $row['price'];
        } else {
            $title = "Добавление счета";
            $fromUrl = "/add_record";
            $btnTitle = "Сохранить";
            $valueDateBill = date('Y-m-d');
            $billValue = '';
        }
        $str .= <<<END
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <h3 class="mb-3">{$title}</h3>
            <form method="post" action="{$fromUrl}">
        END;
        if ($row) {
            $str .= '<input type="hidden" name="id_bill" value="' . $row['id_bill'] . '">';
        }
        // Выбор клиента
        $str .= <<<SELECT1
        <div data-mdb-input-init class="form-outline mt-4 mb-4">
            <label class="form-label" for="selectIdUser">Поставщик:</label>
            <select class="form-select" aria-label="Default select example" name="id_user" id="selectIdUser">
                <option selected>Выберите поставщика</option>
        SELECT1;
        foreach ($clients as $client) {
            if (isset($row["id_user"]) and ($client['id_user'] == $row["id_user"])) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $str .= '<option value="' . $client['id_user'] . '" ' . $selected . '>' . $client['fio'] . '</option>';
        }
        $str .= '</select></div>';

        // Статус
        $str .= <<<SELECT1
        <div data-mdb-input-init class="form-outline mt-4 mb-4">
            <label class="form-label" for="selectStatus">Статус:</label>
            <select class="form-select" aria-label="Default select example" name="status" id="selectStatus">
                <option selected>Выберите статус</option>
        SELECT1;
        $statuses = ["активен", "выплачен", "отменен"];
        foreach ($statuses as $status) {
            if (isset($row["status"]) and ($status == $row["status"])) {
                $selected = "selected";
            } else {
                $selected = "";
            }
            $str .= '<option value="' . $status . '" ' . $selected . '>' . $status . '</option>';
        }
        $str .= '</select></div>';

        $str .= <<<FIELDS
                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form2Example1">Дата:</label>
                    <input type="text" name="date_bill" id="form2Example1"
                        class="form-control" required value="{$valueDateBill}" />
                    <div class="invalid-feedback">Поле обязательно к заполнению</div>
                </div>

                <div data-mdb-input-init class="form-outline mb-4">
                    <label class="form-label" for="form3Example1">Стоимость:</label>
                    <input type="text" name="price" id="form3Example1"
                    class="form-control" value="{$billValue}" />
                </div>

                <!-- Submit button -->
                <button type="submit" data-mdb-button-init data-mdb-ripple-init
                    class="btn btn-primary btn-block mb-4">{$btnTitle}</button>
            </form>
            </div>
        </div>
        <script src="https://localhost/js/bootstrap.bundle.min.js" type="text/javascript"></script>
        FIELDS;
        $resultTemplate =  sprintf($template, $title, $str);
        return $resultTemplate;
    }
}
