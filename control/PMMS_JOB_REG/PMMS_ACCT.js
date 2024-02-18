// import { Tabulator } from 'tabulator-tables'
import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../public/js/j_ui/jquery-ui.min.js'
import '../../node_modules/bootstrap4-toggle/js/bootstrap4-toggle.min.js'
import acct_model from '../../model/PMMS_ACCT_SEL.js'
class PMMS_ACCTG {
    constructor() {
        this.pms_acct = new Tabulator($('#pmms_acctg').get(0), {
            layout: "fitDataTable",
            width: 500,
            columns: [
                { title: 'EMPLOYEE ID', field: 'acct_id' },
                { title: 'USERNAME', field: 'acct_usr' },
                { title: 'EMAILS', field: 'acct_email' },
                { title: 'USER TYPE', field: 'acct_type' },
                {
                    title: '', field: 'acct_action', formatter: (cell) => {
                        const user_btn = document.createElement('button')
                        user_btn.id = `userT-${cell.getRow().getPosition()}`
                        user_btn.className = 'btn btn-primary'
                        user_btn.textContent = 'ACTION'
                        user_btn.addEventListener('click', (events) => {
                            events.stopPropagation();
                            $('#account_').dialog({
                                modal: true,
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: 'close',
                                        click: (events) => {
                                            $(events.target).dialog("close")
                                        }
                                    }
                                ]
                            })
                        })
                        return user_btn
                    }
                },
            ]
        })
        this.operator = new Tabulator($('#pms_operators').get(0), {
            layout: "fitDataTable",
            pagination: "local",
            paginationSize: 10,
            paginationSizeSelector: [5, 10],
            movableColumns: true,
            paginationCounter: "rows",
            columns: [
                { title: 'OPERATOR NAME', field: 'opr_name' },
                { title: 'CODE', field: 'opr_code' },
                { title: 'CODE NAME', field: 'opr_codm' },
                { title: 'PROCESS', field: 'opr_process' },
                { title: 'PROCESS JOB', field: 'opr_job' },
                {
                    title: '', field: 'opr_action', formatter: (cell) => {
                        const opr_btn = document.createElement('button')
                        opr_btn.id = `opr-${cell.getRow().getPosition()}`
                        opr_btn.className = 'btn btn-primary'
                        opr_btn.textContent = 'ACTION'
                        opr_btn.addEventListener('click', (events) => {
                            events.stopPropagation();
                            console.log('only uniuq')
                            $('#operator_').dialog({
                                modal: true,
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: 'close',
                                        click: (events) => {
                                            $(events.target).dialog("close")
                                        }
                                    }
                                ]
                            })
                            $(function () {
                                $(document).on('change', '#prop_operator', (events) => {
                                    var top = $(events.target).prop('checked')
                                    if (top) {
                                        $('#userOptionDiv').removeAttr('style')
                                        $('#passDiv').css({
                                            "display": "none"
                                        })
                                    } else {
                                        $('#userOptionDiv').css({
                                            'display': 'none'
                                        })
                                        $('#passDiv').removeAttr('style')
                                    }
                                })
                            })
                        })
                        return opr_btn
                    }
                },
            ]
        })
        this.$LoadTable()
    }

    $LoadTable() {
        acct_model.$getLogIN((rows) => {
            this.pms_acct.setData(rows)
        })

        acct_model.$getOperator((rows) => {
            this.operator.setData(rows)
        })
    }
}

const pms_acctg = new PMMS_ACCTG()
export default pms_acctg