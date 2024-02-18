import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../public/js/j_ui/jquery-ui.min.js'
import '../../node_modules/htmx.org/dist/htmx.min.js'
import pms_scan_sel from '../../model/PMMS_SCAN_SEL.js'
// import htmx from '../../node_modules/htmx.org/dist/htmx.min.js'
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
            rowFormatter: ($rowz, $cols, _data) => {
                console.log(_data)
            },
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
                { // set the cell to be not to unwrap

                    title: "MOLD STATUS", field: "scan_mold",
                },
                {
                    title: "REMARKS", field: "scan_remarks"
                },
                {
                    title: '', field: "scan_ctrl_no", visible: false
                },
                {
                    title: " ", field: "action", formatter: (cell) => {
                        const self = this
                        const data = cell.getData()
                        console.log(cell.getData()['scan_ctrl_no'])
                        const action = document.createElement('button')
                        action.id = `app_-${cell.getRow().getPosition()}`
                        action.classList.add('btn', 'btn-block', 'btn-primary')
                        action.textContent = 'ADD STATUS'
                        action.addEventListener('click', (events) => {
                            events.stopPropagation();
                            const mold_stat = $('#scan_status_diag').dialog({
                                modal: true,
                                width : '400px',
                                open: (events, ui) => {
                                    $("#current_status").val('')
                                    $("#pms_set_stat").val('')
                                    $("#pms_mold_con").val('')
                                    $("#pms_remarks").val('')
                                    $("#pms_setTime").val('')
                                },
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: 'SUBMIT',
                                        click: (events) => {
                                            // here to address the issue from before in out automatically ongoing with time then the update will have button on the dialog so the user can update separetely 
                                            var SET_STATUS = $('#pms_set_stat').find(':selected').text()
                                            var MOLD_STATUS = $('#pms_mold_con').find(':selected').val()
                                            var TIME_STATUS = $('#current_status').is(':checked');

                                            if (TIME_STATUS == true && ['ONGOING', 'PENDING', 'FOR TRIAL'].includes(SET_STATUS) && MOLD_STATUS == 'NG') {
                                                pms_scan_sel.$runTimeIn({
                                                    "PMS_CONTROL_NO": cell.getData()["scan_ctrl_no"],
                                                    "PROCESS_NAME": cell.getData()['scan_code'].split('-')[0],
                                                    "PROCESS_CODE": cell.getData()['scan_code'].split('-')[1],
                                                    "TIME_IN": $('#pms_setTime').val(),
                                                    "STATUS": SET_STATUS,
                                                    "MOLD_CONDITION": MOLD_STATUS,
                                                    "REMARKS": $('#pms_remarks').val()
                                                }, ($rows) => {
                                                    const mores = JSON.parse($rows)
                                                    this.pms_stattus.addData(mores, true)
                                                    // this.pms_stattus.updateData(cell.getRow().getPosition(), mores)
                                                });

                                            } else if (TIME_STATUS == false && SET_STATUS == 'DONE' && ['GOOD', 'NG'].includes(MOLD_STATUS)) {
                                                pms_scan_sel.$runTimeOut({
                                                    "PMS_CONTROL_NO": cell.getData()["scan_ctrl_no"],
                                                    "PROCESS_NAME": cell.getData()['scan_code'].split('-')[0],
                                                    "PROCESS_CODE": cell.getData()['scan_code'].split('-')[1],
                                                    "TIME_OUT": $('#pms_setTime').val(),
                                                    "STATUS": SET_STATUS,
                                                    "MOLD_CONDITION": MOLD_STATUS,
                                                    "REMARKS": $('#pms_remarks').val()
                                                }, ($rows) => {
                                                    const mores = JSON.parse($rows)
                                                    this.pms_stattus.addData(mores, true)
                                                    // this.pms_stattus.updateData(cell.getRow().getPosition(), mores)
                                                });
                                                console.log('mamba cash is not met')

                                            } else {

                                            }
                                            mold_stat.dialog('close')

                                        }
                                    },
                                    {
                                        text: "UPDATE",
                                        click: (events) => {
                                            let $isChk = $('#current_status').is(':checked');
                                            if ($isChk) {
                                                pms_scan_sel.$runScan({
                                                    "PROCESS_NAME": cell.getData()['scan_code'].split('-')[1],
                                                    "PR_CONTROL_NO": cell.getData()['scan_ctrl_no'],
                                                    "CURR_STAT": $isChk,
                                                    "ID": cell.getData()['action'],
                                                    "TIME_IN": $('#pms_setTime').val(),
                                                    "STATUS": $('#pms_set_stat').find(':selected').text(),
                                                    "MOLD_CONDITION": $('#pms_mold_con').find(':selected').val(),
                                                    "REMARKS": $('#pms_remarks').val()
                                                }, function (ins) {
                                                    var json_s = JSON.parse(ins)
                                                    self.pms_stattus.updateRow(cell.getData()['action'], json_s);
                                                })
                                            } else {
                                                pms_scan_sel.$runScan({
                                                    "PROCESS_NAME": cell.getData()['scan_code'].split('-')[1],
                                                    "PR_CONTROL_NO": cell.getData()['scan_ctrl_no'],
                                                    "CURR_STAT": $isChk,
                                                    "ID": cell.getData()['action'],
                                                    "TIME_OUT": $('#pms_setTime').val(),
                                                    "STATUS": $('#pms_set_stat').find(':selected').text(),
                                                    "MOLD_CONDITION": $('#pms_mold_con').find(':selected').val(),
                                                    "REMARKS": $('#pms_remarks').val()
                                                }, (outs) => {
                                                    var json_ = JSON.parse(outs)
                                                    self.pms_stattus.updateRow(cell.getData()['action'], json_)
                                                })
                                            }
                                        }
                                    },
                                    {
                                        text: 'CLOSE',
                                        click: (events) => {
                                            mold_stat.dialog('close')
                                        }
                                    }
                                ]
                            })

                            mold_stat.dialog('open')
                            console.log(cell.getData()['action'])

                        })
                        return action
                    }
                }
            ]
        })
        this.loadStatus()
    }


    loadStatus() {
        const self = this
        this.pms_stattus.on('tableBuilt', () => {
            this.pms_stattus.setData([{
                scan_code: '',
                scan_out: '',
                scan_in: ''
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
                            // htmx.ajax('POST', '/1_PMMS_MOLD/db_php/scanner/scan_inout.php', {
                            //     values : {
                            //         'pms' : `${$('#pmsToScan').val()}|${$rows.getData()['scan_proc']}|${selected}`
                            //     },
                            //     event: 'click',
                            //     target: '#mainContent',
                            //     swap: 'outerHTML'

                            // })

                            $.ajax({
                                url: '/1_PMMS_MOLD/db_php/scanner/scan_inout.php',
                                method: 'POST',
                                source: '',
                                data: {
                                    'pms': `${$('#pmsToScan').val()}|${$rows.getData()['scan_proc']}|${selected}`
                                },
                                success: function (data) {
                                    let json = JSON.parse(data)
                                    self.pms_stattus.setData(json)
                                    $('#mainContent').css({
                                        "display": "none"
                                    });
                                    $('#pms_list_plan').css({
                                        "display": 'none'
                                    })
                                    $('#pms_data_plan').removeAttr('style');
                                    console.log(data)
                                }, error: (err) => {
                                    console.log(err)
                                }
                            })

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
                width: '500px',
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
                values: {
                    'pms': 'un_process_plan'
                },
                target: '#unplan_proc',
                event: 'once',
                swap: 'innerHTML'
            })
            unplan_diag.dialog('open')
        })

        $(document).on('click', '#unplan_btn', (events) => {
            let unplan_proc = $("#unplan_proc").find(':selected').text().split('—')
            var $timeVal = $('#unplan_time').val()
            var [$hours, $minutes] = $timeVal.split(':')
            var totalMinutes = parseInt($hours) * 60 + parseInt($minutes);
            $.ajax({
                url: '/1_PMMS_MOLD/db_php/scanner/scan_in_unplanned.php',
                method: 'POST',
                data: {
                    'pms': [
                        $('#pmsToScan').val(),
                        unplan_proc[0],
                        $("#unplan_emp_id").val(),
                        totalMinutes,
                        $("#unplan_name").find(':selected').text()
                    ]
                }, success: (data) => {
                    const add_process = JSON.parse(data)
                    this.pms_ctrlNo_tb.addData(add_process, true);
                }
            })
        })
    }

}
const pmms_v2 = new PMMS_SCAN_V2();
export default pmms_v2;