import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../public/js/j_ui/jquery-ui.min.js'
import '../../node_modules/htmx.org/dist/htmx.min.js'
import pms_scan_sel from '../../model/PMMS_SCAN_SEL.js'
import htmx from '../../node_modules/htmx.org/dist/htmx.min.js'
// import { Tabulator } from 'tabulator-tables'
class PMMS_SCAN_V2 {
    constructor() {
        this.pms_ctrlNo_tb = new Tabulator($('#scan_start_tb').get(0), {
            layout: "fitDataFill",
            height: 450,
            columns: [
                { title: "PROCESS NAME", field: "scan_proc" },
                { title: "OPERATOR NAME", field: "scan_opr" },
                { title: "EMPLOYEE ID", field: "scan_id" },
                { title: "PLAN(mins)", field: "scan_mins" }

            ]
        })
        this.pms_stattus = new Tabulator($('#pms_InOut').get(0), {
            // layout: "fitColumns",
            height: 450,
            columns: [
                {
                    title: "PROCESS CODE", field: "scan_code", formatter: (cell) => {
                        return cell.getData()['scan_code']
                    }
                },
                {
                    title: "IN", field: "scan_in", width: 150, formatter: (cell) => {
                        if (cell.getField() == 'scan_in') {
                            let text_center = cell.getColumn().getElement()// text center
                            // console.log(text_center)
                            $(text_center).on('click', (events) => {
                                console.log('data')
                            })
                            $(text_center).addClass('text-center');
                            $(text_center).css({
                                "background-color": "green"
                            })
                            $(text_center).find('.tabulator-col-title').css({
                                "color": "white",
                                "font-size": "large",
                                "font-family": "Verdana, Geneva, Tahoma, sans-serif;",
                                "font-weight": "bolder"
                            })
                            return cell.getData()['scan_in']
                        }
                    }
                },
                {
                    title: "OUT", field: "scan_out", width: 150, formatter: (cell) => {
                        if (cell.getField() == 'scan_out') {
                            let text_center = cell.getColumn().getElement()// back ground color
                            $(text_center).addClass('text-center');
                            $(text_center).css({
                                "background-color": "red"
                            })
                            $(text_center).find('.tabulator-col-title').css({
                                "color": "white",
                                "font-size": "large",
                                "font-family": "Verdana, Geneva, Tahoma, sans-serif;",
                                "font-weight": "bolder"
                            })
                        }
                        return cell.getData()['scan_out']
                    }
                },
                {
                    title: " ", field: "action", formatter: (cell) => {
                        const action = document.createElement('button')
                        action.id = `app_-${cell.getRow().getPosition()}`
                        action.classList.add('btn', 'btn-block', 'btn-primary')
                        action.textContent = 'Approve'
                        action.addEventListener('click', (events) => {
                            events.stopPropagation();
                            const mold_stat = $('#scan_status_diag').dialog({
                                modal: true,
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: 'SUBMIT',
                                        click: (events) => {
                                            mold_stat.dialog('close')
                                        }
                                    }, {
                                        text: 'CLOSE',
                                        click: (events) => {
                                            mold_stat.dialog('close')
                                        }
                                    }
                                ]
                            })
                            mold_stat.dialog('open')

                        })
                        return action
                    }
                }
            ]
        })
        this.loadStatus()
    }


    loadStatus() {
        this.pms_stattus.on('tableBuilt', () => {
            this.pms_stattus.setData([{
                scan_code: 'this',
                scan_out: 'this',
                scan_in: 'this'
            }])
        })

        $(document).on('change', '#pmsToScan', (events) => {
            pms_scan_sel.$list_mold($(events.target).val(), ($row) => {
                this.pms_ctrlNo_tb.setData($row)
            })
        })

        this.pms_ctrlNo_tb.on('rowClick', (events, $rows) => {
            // alert($rows.getData()['scan_opr'])
            const onInOut = $('#onScan').dialog({
                open: (events, ui) => {
                    const form_group = $('#onScan')
                    form_group.find('.form-group').empty()

                    const label = document.createElement('label');
                    label.classList.add('control-label')
                    label.textContent = 'SELECT PROCESS CODE'
                    const un_plan_select = document.getElementById('un_procName')

                    const selector = document.createElement('select')
                    selector.name = 'pms_process_code'
                    selector.id = 'pms_process_code'
                    selector.classList.add('form-control')
                    pms_scan_sel.$list_mold_code($rows.getData()['scan_proc'], ($opt) => {
                        console.log($opt)
                        $opt.map((value, index) => {
                            let opt_val = `${value['PMS_CODE']} — ${value['PMS_OP_NAME']} — ${value['PMS_CODENAME']}`
                            selector[index] = new Option(opt_val, value['PMS_CODE']);
                            // un_plan_select[index] = new Option(opt_val, value['PMS_CODE']);
                        })
                        selector.addEventListener('change', (events) => {
                            events.preventDefault()

                        })
                    })
                    form_group.find('#formScan').prepend(label)
                    form_group.find('#formScan').append(selector)

                },
                modal: true,
                closeOnEscape: false,
                width: '40%',
                buttons: [
                    {
                        text: "PROCEED",
                        click: (events) => {
                            $('#mold_ctrl').find(':selected').text()
                            var selected = $('#pms_process_code').find(':selected').val()
                            htmx.ajax('POST', '/1_PMMS_MOLD/db_php/scanner/scan_inout.php', {
                                values: {
                                    'pms': selected
                                },
                                target: '#mainContent',
                                event: 'click',
                                swap: 'outerHTML'

                            })

                            htmx

                            $('#onScan').dialog('close')
                        }
                    }, {
                        text: 'CLOSE',
                        click: (events) => {
                            $('#onScan').dialog('close')
                        }
                    }
                ]

            })

        })

        $(document).on('click', '#unPlanBtn', (events) => {
            const unplan_diag = $('#unPlanScaned').dialog({
                modal: true,
                closeOnEscape: false,
                buttons: [
                    {
                        text: 'CLOSE',
                        click: (events) => {
                            unplan_diag.dialog('close')
                        }
                    }
                ]
            })

            htmx.ajax('POST', '/1_PMMS_MOLD/db_php/select/pms_addNewPlan.php', {
                values : {
                    'pms' : 'un_process_plan'
                },
                target : '#unplan_proc',
                event : 'once',
                swap : 'innerHTML'
            })

            htmx.ajax('POST', '/1_PMMS_MOLD/db_php/select/pms_addNewPlan.php', {
                values : {
                    'pmst' : 'un_people'
                },
                target : '#unplan_name',
                event : 'click',
                swap : 'innerHTML'
            })
        

            unplan_diag.dialog('open')
        })
    }

}
const pmms_v2 = new PMMS_SCAN_V2();
export default pmms_v2;