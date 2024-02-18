<?php
class HTML_TEMPLATES
{
    public function __construct(
        public string $id,
        public array $data = [],
    ) {
    }

    public function html_renders()
    {
        ?>
        <div class="alert alert-warning">
            <div class="row">
                <div class="col-3 table-responsive">
                    <br />
                    <br />
                    <?php $this->data; ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th class="text-nowrap">CONTROL #</th>
                                <td class="text-nowrap">PR2024-102122</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">MODEL #</th>
                                <td class="text-nowrap">PTTM17-036</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-9 table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col" colspan="7">
                                    <span style="text-align: center;">
                                        PRODUCTION RUN DETAILS
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-nowrap">PROCESS</th>
                                <td class="text-nowrap">Row 1, Cell 2</td>
                                <th class="text-nowrap">START TIME</th>
                                <td class="text-nowrap">Row 1, Cell 3</td>
                                <th class="text-nowrap">DIVISION</th>
                                <td class="text-nowrap">Row 1, Cell 3</td>
                                <td rowspan="2">sddssss</td>
                            </tr>
                            <tr>
                                <th class="text-nowrap">CODE</th>
                                <td class="text-nowrap">Row 2, Cell 2</td>
                                <th class="text-nowrap">PLAN(min)</th>
                                <td class="text-nowrap">Row 2, Cell 3</td>
                                <th class="text-nowrap">STATUS</th>
                                <td style="background-color: green;">Row 2, Cell 3</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
    }
}
