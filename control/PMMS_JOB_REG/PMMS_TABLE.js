// import { Tabulator } from 'tabulator-tables'
// import htmxMin from '../../node_modules/htmx.org/dist/htmx.min.js'

import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../node_modules/select2/dist/js/select2.full.min.js'
import '../../node_modules/htmx.org/dist/htmx.min.js'
// import '../../public/js/qr_code/qrcode.min.js'
import select_job_no from '../../model/PMMS_SELECT_JO.js'
import pms_del from '../../model/PMMS_DELETE_JO.js'
import pms_update from '../../model/PMMS_UPDATE_JO.js'
import pmms_view from '../../view/PMMS_INSERT_VIEW.js'
import pmms_job_bo from '../../model/PMMS_INSERT_JO.js'
import qrclass from './PMMS_QRCODE.js'

class PMMS_TABLE_CALL {
    constructor() {
        this.self = this
        this.mold_selection = () => {
            $.ajax({
                url: '../db_php/select/pms_regs.php',
                method: 'POST',
                data: {
                    'pms': [
                        'mold_process'
                    ],
                },
                success: (data) => {
                    $('#proc_name').empty()
                    const mold_proc = JSON.parse(data)
                    mold_proc.map((val, index) => {
                        $(document).find('#proc_name').append(new Option(val['IN_PROCESS'], val['IN_PROCESS'], false))
                        // console.log(val)
                    })

                }, error: (err) => {
                    console.log(err)
                }
            })
        }

        this.isTime = function getTimeDifferenceInMinutes(userTime) {
            const [userHours, userMinutes] = userTime.split(':');
            const userTimeInMinutes = parseInt(userHours) * 60 + parseInt(userMinutes);
          
            const currentDate = new Date();
            const currentHours = currentDate.getHours();
            const currentMinutes = currentDate.getMinutes();
            const currentTimeInMinutes = currentHours * 60 + currentMinutes;
          
            const timeDifferenceInMinutes = userTimeInMinutes - currentTimeInMinutes;
          
            if (timeDifferenceInMinutes < 0) {
              return 'The user-provided time has already passed.';
            }
          
            return timeDifferenceInMinutes;
          }
        this.pms_reg = new Tabulator($('#pms_insert_table').get(0), {
            layout: "fitDataFill",
            height: 500,
            width: 100,
            // selectable : 10,
            columns: [
                { title: 'CONTROL NO', field: 'pms_tb_ctrl' },
                { title: 'JOB ORDER', field: 'pms_tb_order' },
                { title: 'MOLD CODE', field: 'pms_tb_mcode' },
                { title: 'MODEL', field: 'pms_tb_model' },
                { title: 'MOLD NAME', field: 'pms_tb_modelm' },
                { title: 'TYPE', field: 'pms_tb_type', },
                { title: 'DEFECT', field: 'pms_tb_defect' },
                { title: 'DEFECT DETAIL', field: 'pms_tb_detail' },
                { title: 'DEFECT CAV', field: 'pms_tb_cav' },
                { title: 'QUANTITY', field: 'pms_tb_qty' },
                {
                    title: '', field: 'pms_update', frozen: true, formatter: (cell) => {
                        const btn_update = document.createElement('button');
                        btn_update.textContent = 'UPDATE'
                        btn_update.classList.add('btn', 'btn-warning')
                        btn_update.id = `pms-${cell.getData()['id']}`
                        btn_update.addEventListener('click', (events) => {
                            var pms_insert_table_id = cell.getRow().getPosition()
                            var sampleDTD = cell.getData();
                            sampleDTD['id'] = pms_insert_table_id
                            sampleDTD['pms_tb_ctrl'] = $('#pms_ctrlno').val()
                            sampleDTD["pms_tb_mcode"] = $('#mold_ctrl').find(':selected').text()
                            sampleDTD["pms_tb_model"] = $('#pms_model').val()
                            sampleDTD["pms_tb_modelm"] = $('#pms_mold_name').val()
                            sampleDTD["pms_tb_type"] =  $('#chkgroup').find('input:checked').val()
                            sampleDTD["pms_tb_defect"] = $('#pms_defect').val()
                            sampleDTD["pms_tb_detail"] = $('#pms_detail').val()
                            sampleDTD["pms_tb_cav"] = $('#pms_cav').val()
                            sampleDTD["pms_tb_qty"] = $('#pms_qty').val()
                            sampleDTD["pms_tb_order"] = $('#pms_jobno').val()
                            this.pms_reg.updateRow(pms_insert_table_id, sampleDTD)


                            console.log(sampleDTD)
                            pms_update.PMMS_REG_LIST_UPDATE(sampleDTD, (data) => {
                                console.log(data)
                            })

                        })

                        return btn_update
                    }
                },
                {
                    title: '', field: 'pms_tb_del', frozen: true, formatter: (cell) => {
                        const btn_del = document.createElement('button')
                        btn_del.textContent = 'DELETE'
                        btn_del.classList.add('btn', 'btn-danger')
                        btn_del.id = `pms_del-${cell.getData()['id']}`
                        btn_del.addEventListener('click', (events) => {
                            pms_del.PMMS_DELETE_REG({
                                'id': cell.getData()['id'],
                                'ctrl_no': cell.getData()['pms_tb_ctrl']
                            }, (msg) => {
                                if (msg['msg'] == 'true') {
                                    cell.getRow().delete()
                                }
                            })
                        })
                        return btn_del
                    }
                }

            ]
        })
        this.pms_drawUpload = new Tabulator($('#pms_drawTable').get(0), {
            layout: "fitDataFill",
            height: 500,
            columns: [
                { title: "PR CONTROL #", field: "pr_ctrl" },
                { title: "DRAWING CONTROL #", field: "pms_draw" },
                {
                    title: "", field: "draw_add", formatter: (cell) => {
                        const self = this
                        const id = cell.getRow().getPosition()
                        var addDrawBtn = document.createElement('button');
                        addDrawBtn.textContent = 'ADD DRAWING'
                        addDrawBtn.id = `app_draw-${id}`;
                        addDrawBtn.classList.add('btn', 'btn-primary')
                        addDrawBtn.addEventListener('click', (events) => {
                            let addDrawing = $('#addDrawDialog').dialog({
                                title: "DRAWING INFORMATION",
                                modal: true,
                                open: (events, ui) => {
                                    $('#title_draw').val(' ')
                                    $('#pic_name').val(' ')
                                    $('#draw_hide').removeAttr('style')
                                },
                                close: (events, ui) => {

                                },
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: "INSERT DRAWING",
                                        click: function (events) {
                                            let PR_CTRL = {
                                                "PMS_CONTROL_NO": cell.getData()['pr_ctrl'],
                                                "PMS_DRAW_NO": cell.getData()['pms_draw'],
                                                "PMS_DRAW_NAME": $('#title_draw').val(),
                                                "PMS_PIC_NAME": $('#pic_name').val(),
                                            }
                                            pmms_job_bo.REG_INSERT_FILE(PR_CTRL, (row) => {
                                                if (typeof row != 'object') {
                                                    alert("ERROR : " + row);
                                                } else {
                                                    document.location.reload(true)
                                                    self.mediaDrawList(row)
                                                    self.pms_plan.redraw()
                                                }
                                            })
                                        }
                                    },
                                    {
                                        text: "Close",
                                        click: function (events) {
                                            $(this).dialog('close')
                                        }
                                    }
                                ]
                            })


                        })
                        return addDrawBtn
                    }
                }
            ]
        })
        this.pms_plan = new Tabulator($('#plan2draw').get(0), {
            layout: "fitDataFill",
            width : '50%',
            height: 500,
            columns: [
                { title: "PR CONTROL #", field: "plan_ctrl" },
                { title: "MOLD CODE #", field: "mold_code" },
                { title: "JOB ORDER #", field: "mold_job_order" },
                { title: "DRAWING CONTROL #", field: "plan_draw" },
                { title: "DRAWING COUNT #", field: "plan_count" },
                { title: "PLANING COUNT #", field: "plan_plan_count" },
                {
                    title: " ", field: "action_plan", formatter: (cell) => {
                        var btnPlanAdd = document.createElement('button')
                        var planCnt = cell.getData()['plan_plan_count']
                        btnPlanAdd.id = `plan_ac-${cell.getRow().getPosition()}`
                        btnPlanAdd.classList.add('btn', 'btn-primary')
                        btnPlanAdd.textContent = 'ADD PLAN'
                        btnPlanAdd.disabled = false
                        btnPlanAdd.addEventListener('click', (events) => {
                            this.mold_selection()
                            this.add_plan(cell.getData()['plan_ctrl'])
                            
                        })

                        return btnPlanAdd
                    }
                },
                {
                    title: " ", field: 'qrcode_plan', formatter: (cell) => {
                        let count = cell.getRow().getPosition()
                        let plan_count = cell.getData()['plan_plan_count']
                        let btn_qr = document.createElement('button')
                        btn_qr.classList.add('btn', 'btn-primary')
                        btn_qr.textContent = 'QR-CODE'
                        btn_qr.id = `qrcode-${count}`
                        btn_qr.addEventListener('click', (events) => {
                            $('#qr_dialog').dialog({
                                modal: true,
                                width: '50%',
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: "close",
                                        click: (events) => {
                                            $('#qr_dialog').dialog('close')
                                        }
                                    }
                                ]
                            })
 
                            $.ajax({
                                url: `/1_PMMS_MOLD/db_php/qrcode/render_qrcode.php?mold_id=${cell.getData()['plan_ctrl']}`,
                                method: 'POST',
                                data: {
                                    'pms': [
                                        'qrcode'
                                    ]
                                }, success: (data) => {
                                    let qr_data = cell.getData()
                                    let server_data = JSON.parse(data)
                                    console.log(server_data)
                                    qrclass.$QR_1(server_data)
                                }, error: (err) => {
                                    console.log(err)
                                }
                            })
                            
                        })
                        return btn_qr
                    }
                }
            ], rowFormatter: (row) => {
                row.getCells().map((cell, index) => {
                    if (cell.getField() == 'plan_qrcode') {
                        var qr_id = $(cell.getElement()).find('div')
                        var qr_attr = $(qr_id)?.attr('id')


                        console.log(typeof qr_attr)
                    }
                })
            }
        })
        this.pms_list = new Tabulator($('#mold_table').get(0), {
            layout: "fitDataFill",
            height: 500,
            columns: [
                { title: "", field: "mold_id", visible: false },
                { title: "PROCESS NAME", field: "mold_name" },
                { title: "PROCESS TIME(mins)", field: "mold_time" },
                { title: "P.I.C NAME", field: "mold_employee" },
                {
                    title: "", field: "mold_update", formatter: (cell) => {
                        let self = this
                        let mold_data = cell.getData()
                        let mold_id = cell.getRow().getData()['mold_id'];
                        let row_id = cell.getRow().getPosition()
                        let mold_update = document.createElement("button")
                        mold_update.textContent = "UPDATE"
                        mold_update.classList.add('btn', 'btn-warning')
                        mold_update.addEventListener('click', (events) => {
                            this.mold_selection()
                            let mold_update_dialog = $('#pms_action_plan').dialog({
                                modal: true,
                                closeOnEscape: false,
                                open: (events, ui) => {
                                    $('#pms_action_plan').find('input, select').each((index, elem) => {
                                        if ($(elem).get(0).tagName.toLowerCase == "select") {
                                            $(elem).append(new Option('Select new Process', 'NEW_PROCESS'))
                                        } else {
                                            $(elem).val('')
                                        }
                                    })
                                },
                                buttons: [
                                    {
                                        text: 'PROCEED',
                                        click: (events) => {
                                            var $timeVal = $('#proc_mins').val()
                                            var totalMinutes = this.isTime($timeVal)
                                            const update_fetch = {
                                                PMSID: mold_id,
                                                PROCESS_NAME: $('#proc_name').val(),
                                                PIC_NAME: $('#pms_name').val(),
                                                PLAN_TIME: totalMinutes,
                                            }
                                            mold_data['id'] = row_id
                                            mold_data['mold_name'] = update_fetch['PROCESS_NAME']
                                            mold_data['mold_time'] = update_fetch['PLAN_TIME']
                                            mold_data['mold_employee'] = update_fetch['PIC_NAME']
                                            this.pms_list.updateRow(row_id, mold_data)
                                            pms_update.PMS_PLAN_UPDATE(update_fetch, (rows) => {
                                                console.log(rows)
                                            })
                                            mold_update_dialog.dialog('close')
                                            console.log(update_fetch)
                                        }
                                    }, {
                                        text: 'CANCEL',
                                        click: (events) => {
                                            mold_update_dialog.dialog('close')
                                        }
                                    }
                                ]
                            })
                            mold_update_dialog.dialog('open')

                            console.log('ontere11')
                        })

                        return mold_update
                    }
                },
                {
                    title: "", field: "mold_delete", formatter: (cell) => {
                        let mold_id = cell.getRow().getData()['mold_id'];
                        let mold_delete = document.createElement("button")
                        mold_delete.textContent = "DELETE"
                        mold_delete.classList.add('btn', 'btn-warning')
                        mold_delete.addEventListener('click', (events) => {
                            let moldDel_dialog = $('#mold_confirm').dialog({
                                modal: true,
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: "CONFIRM DELETION",
                                        click: (events) => {
                                            pms_del.PMS_DELPLAN(mold_id, (rows) => {
                                                cell.getRow().delete()
                                                console.log(rows);

                                            })
                                            $('#mold_confirm').css({
                                                display: "none"
                                            })
                                            $('#pms_action_plan').removeAttr('style')
                                            console.log('ontere')
                                            moldDel_dialog.dialog('close')
                                        },
                                    }, {
                                        text: "CANCEL",
                                        click: (events) => {
                                            $('#mold_confirm').css({
                                                display: "none"
                                            })
                                            $('#pms_action_plan').removeAttr('style')
                                        }
                                    }
                                ]
                            })
                        })

                        return mold_delete
                    }
                },
            ]
        })
        this.pms_onlyPlan = new Tabulator($('#mold_plan').get(0), {
            height: 300,
            columns: [
                { title: "PR CONTROL NO", field: "mold_plan_ctrl" },
                { title: "MOLD CODE", field: "mold_plan_code" },
                { title: "JOB ORDER", field: "mold_plan_job" },
                { title: "PLAN COUNT", field: "mold_plan_count" },
                {
                    title: "", field: "mold_plan_add", formatter: (cell) => {
                        let mold_btn = document.createElement('button')
                        mold_btn.classList.add('btn', 'btn-primary', 'fa', 'fa-plus');
                        mold_btn.id = `molds_-${cell.getRow().getPosition()}`
                        mold_btn.textContent = 'ADD PLAN'
                        mold_btn.addEventListener("click", (events) => {
                            this.mold_selection()
                            this.add_plan(cell.getData()['mold_plan_ctrl'])
                        })
                        return mold_btn;
                    }
                },
                {
                    title: "", field: "mold_plan_qr", formatter: (cell) => {
                        let mold_qr = document.createElement('button')
                        mold_qr.classList.add('btn', 'btn-primary', 'fa', 'fa-plus');
                        mold_qr.id = `molds_-${cell.getRow().getPosition()}`
                        mold_qr.textContent = 'QR-CODE'
                        mold_qr.addEventListener("click", (events) => {
                            console.log(cell.getData()['mold_plan_ctrl'])
                            $('#qr_dialog').dialog({
                                modal: true,
                                width: '50%',
                                closeOnEscape: false,
                                buttons: [
                                    {
                                        text: "close",
                                        click: (events) => {
                                            $('#qr_dialog').dialog('close')
                                        }
                                    }
                                ]
                            })
 
                            $.ajax({
                                url: `/1_PMMS_MOLD/db_php/qrcode/render_qrcode.php?mold_id=${cell.getData()['mold_plan_ctrl']}`,
                                method: 'POST',
                                data: {
                                    'pms': [
                                        'qrcode'
                                    ]
                                }, success: (data) => {
                                    const mold_data = JSON.parse(data)
                                    qrclass.$QR_2(mold_data)
                                }, error: (err) => {
                                    console.log(err)
                                }
                            })
                        })
                        return mold_qr;
                    }
                },
            ]
        })
        this.add_plan = (data) => {
            var addPlanBtn = $('#pms_action_plan').dialog({
                open: (events) => {
                    $(this).find('input').val('')
                },
                modal: true,
                closeOnEscape: false,
                buttons: [
                    {
                        text: "SAVE",
                        click: (events) => {
                            var totalMinutes = this.isTime($('#proc_mins').val())
                            const mold_data = {
                                "PMS_CONTROL_NO": data,
                                "PROCESS_NAME": $('#proc_name').val(),
                                "PLAN_TIME": totalMinutes,
                                "PIC_NAME": $('#pms_name').val(),
                                "PMS_PIC_ID": $('#pms_picid').val()
                            }
                            pmms_job_bo.PMS_MOLD_INSERT(mold_data, (row) => {
                                const moldlist_map = row.map((val, index) => {
                                    return {
                                        mold_id: val['PMSID'],
                                        mold_name: val['PROCESS_NAME'],
                                        mold_employee: val['PIC_NAME'],
                                        mold_time: val['PLAN_TIME']
                                    }
                                })
                                this.pms_list.setData(moldlist_map)
                                this.pms_plan.updateData([{
                                    'id': cell.getRow().getIndex(),
                                    'plan_plan_count': cell.getData()['plan_plan_count'] + 1
                                }])
                            })
                        }
                    },
                    {
                        text: "CLOSE",
                        click: (events) => {
                            addPlanBtn.dialog('close')
                        }
                    }
                ]

            })
        }
        this.weekGen = (callback) => {
            $.ajax({
                url: '../db_php/select/pms_regs.php',
                method: 'POST',
                data: {
                    'pms': [
                        'week_gen'
                    ]
                }, success: (data) => {
                    callback(data)
                    // console.log(data)
                }, error: (err) => {
                    console.log(err)
                }
            })
        }
        this.mediaDrawList = (array) => {
            $('#draw_upload').empty()
            var $newList = $('<div>')
            array.forEach((index_row, index) => {
                var $drawing_result = $(`<li class="media col-xs-5 m-1" id="draw_list-${index}">
                <img src="../dump_/image_def.png" alt="" style="width: 100px; height:100px" class="ml-2">
                <div class="media-body m-1">
                    <h5 class="mt-0 mb-1" style="word-wrap: break-word">${index_row['PMS_DRAW_NAME']}</h5>
                    <p class="text-wrap">${index_row['PMS_PIC_NAME']}</p>
                    <div class="row m-2">
                    <a id="draw_update-${index}" data-id="${index_row['PMSID']}"class="badge badge-warning m-1" type="button">UPDATE</a>
                    <a id="draw_delete-${index}" data-id="${index_row['PMSID']}"class="badge badge-danger m-1"type="button">DELETE</a>
                </div>
                </div>
            </li>`);
                let draw_Update = $drawing_result.find(`#draw_update-${index}`)
                draw_Update.on('click', (events) => {
                    const update_id = events.target.getAttribute('data-id')
                    const root_content = $(events.target).parent().parent()
                    var $update_dialog = $('#addDrawDialog').dialog({
                        title: "DRAWING INFORMATION",
                        modal: true,
                        open: (events, ui) => {

                            $('#title_draw').val(' ')
                            $('#pic_name').val(' ')
                        },
                        closeOnEscape: false,
                        buttons: [
                            {
                                text: "UPDATE",
                                click: (events) => {
                                    const objUpdate = {
                                        "PMSID": update_id,
                                        "PMS_DRAW_NAME": $(document).find('#title_draw').val(),
                                        "PMS_PIC_NAME": $(document).find('#pic_name').val()
                                    }
                                    root_content.find('h5').text(objUpdate['PMS_DRAW_NAME'])
                                    root_content.find('p').text(objUpdate['PMS_PIC_NAME'])
                                    pms_update.PMS_DRAW_UPDATE(objUpdate, (data) => {
                                        console.log(data)
                                        $update_dialog.dialog('close')
                                    })
                                    console.log("on update")
                                }
                            }, {
                                text: "CLOSE",
                                click: (events) => {
                                    $update_dialog.dialog('close')
                                }
                            }
                        ]
                    })
                    $update_dialog.dialog('open')
                })


                let draw_Delete = $drawing_result.find(`#draw_delete-${index}`)
                draw_Delete.on('click', (events) => {
                    const delete_id = events.target.getAttribute('data-id')
                    const root_draw = $(events.target).parent().parent().parent()
                    var deleteDialog = $('#addDrawDialog').dialog({
                        title: "DRAWING INFORMATION",
                        modal: true,
                        open: (events, ui) => {
                            $('#draw_warning').removeAttr('style')
                            $('#draw_hide').css({
                                "display": "none"
                            })
                        }, closeOnEscape: false,
                        buttons: [
                            {
                                text: "DELETE",
                                click: (events) => {
                                    pms_del.PMMS_DELETE_DRAW(delete_id, (row_del) => {
                                        root_draw.remove()
                                        deleteDialog.dialog('close')
                                    })
                                }
                            }, {
                                text: "CLOSE",
                                click: (events) => {
                                    $('#draw_hide').removeAttr('style')
                                    $('#draw_warning').css({
                                        "display": "none"
                                    })
                                    deleteDialog.dialog('close')

                                }
                            }
                        ]
                    })
                })
                $('#draw_upload').append($drawing_result)
            });
        }
        this.findObject = (arr, valueToFind) => {
            return arr.find(function (obj) {
                return obj.value === valueToFind;
            });
        }
        this.PMS_TABLE_REGISTRATION()
        this.DRAWING_TABLE()
    }

    PMS_TABLE_REGISTRATION() {
        const self = this
        $.ajax({
            url: '../db_php/select/pms_regs.php',
            method: 'POST',
            data: {
                'pms': [
                    'mold_list'
                ]
            }, success: (data) => {
                const mold_list = JSON.parse(data)
                const mold_data = mold_list.map((value, index) => {
                    return {
                        id: index,
                        text: value['MOLD_CTRL_NO']
                    }
                })
                $('#mold_ctrl').select2({
                    data: mold_data,
                    theme: 'classic',
                    templateSelection: (state) => {
                        const select_mold = mold_list.map((value, index) => {
                            if (value['MOLD_CTRL_NO'] == state.text) {
                                let mold_ = mold_list[index]
                                // console.log(mold_list[index])
                                $('#pms_customer').val(mold_['CUSTOMER'])
                                $('#pms_model').val(mold_['MODEL'])
                                $('#pms_mold_name').val(mold_['MOLD_NAME'])
                                $('#pms_mark').val(mold_['MARK_NO'])
                                $('#pms_cav2').val(mold_['CAVI_NO'])
                                $('#pms_loc').val(mold_['MP_LOC'])
                                $('#pms_part').val(mold_['PART_NO'])

                            }
                        })
                        return state.text
                    },
                })
            }, error: (err) => {
                console.log(err)
            }
        })

        this.weekGen((incre_data) => {
            $('#pms_jobno').val(incre_data)
            // console.log($('#mold_ctrl option:selected').text())
        })

        select_job_no.PMS_REGISTERED((row) => {
            let pms_regsData = row.map((val, index) => {
                return {
                    id: index,
                    pms_tb_ctrl: val['PMS_CONTROL_NO'],
                    pms_tb_mcode: val['MOLD_CTRL_NO'],
                    pms_tb_model: val['MODEL'],
                    pms_tb_modelm: val['MOLD_NAME'],
                    pms_tb_type: val['TYPE'],
                    pms_tb_defect: val['DEFECT'],
                    pms_tb_detail: val['DEFECT_DETAIL'],
                    pms_tb_cav: val['DEFECT_CAV'],
                    pms_tb_qty: val['QUANTITY'],
                    pms_tb_order: val['PMS_JOB_NO'],
                }
            })
            this.pms_reg.setData(pms_regsData)
        })

        select_job_no.PMS_DRAW_REG((row) => {
            let pms_draw = row.map((value, index) => {
                return {
                    pr_ctrl: value['PMS_CONTROL_NO'],
                    pms_draw: value['PMS_DRAW_NO'],
                }
            })
            this.pms_drawUpload.setData(pms_draw)
        })

        select_job_no.PMS_COUNT_DRAW((rows) => {
            let plan_draw = rows.map((value, index) => {
                return {
                    plan_ctrl: value['PMS_CONTROL_NO'],
                    plan_draw: value['PMS_DRAW_NO'],
                    plan_count: value['DRAW_COUNT'],
                    plan_plan_count: value['PLAN_COUNT'],
                    mold_code: value['MOLD_CODE'],
                    mold_job_order: value['JOB_ORDER']
                }
            })
            this.pms_plan.setData(plan_draw)
        })

        select_job_no.PMS_MOLD_PLAN((data) => {
            this.pms_onlyPlan.setData(data)
        })

        this.pms_plan.on('rowClick', (events, row) => {
            const ctrl_no = row.getData()['plan_ctrl']
            select_job_no.PMS_MOLD_LIST(ctrl_no, (ross) => {
                console.log(ross)
                const moldlist_map = ross.map((val, index) => {
                    return {
                        mold_id: val['PMSID'],
                        mold_name: val['PROCESS_NAME'],
                        mold_employee: val['PIC_NAME'],
                        mold_time: val['PLAN_TIME']
                    }
                })
                this.pms_list.setData(moldlist_map)
            })
        })

        this.pms_onlyPlan.on('rowClick', (events, row) => {
            const pr_list = row.getData()['mold_plan_ctrl']
            select_job_no.PMS_MOLD_LIST(pr_list, (ross) => {
                console.log(ross)
                const moldlist_map = ross.map((val, index) => {
                    return {
                        mold_id: val['PMSID'],
                        mold_name: val['PROCESS_NAME'],
                        mold_employee: val['PIC_NAME'],
                        mold_time: val['PLAN_TIME']
                    }
                })
                this.pms_list.setData(moldlist_map)
            })
        })

        this.pms_reg.on('rowClick', function (e, row) {
            // table getFData for input source table
            // ajax for mold list 
            const pmg_reg_row = row.getData()
            console.log(pmg_reg_row)
            $.ajax({
                url: '../db_php/select/pms_regs.php',
                method: 'POST',
                data: {
                    'pms': [
                        'mold_list'
                    ]
                }, success: (data) => {
                    const mold_list = JSON.parse(data)
                    const findMold = mold_list.find(mold_ctrl => pmg_reg_row['pms_tb_mcode'] == mold_ctrl['MOLD_CTRL_NO'])
                    console.log(findMold)
                    $('#pms_ctrlno').val(pmg_reg_row['pms_tb_ctrl'])
                    $('#pms_jobno').val(pmg_reg_row['pms_tb_order'])
                    $('#mold_ctrl').find(':selected').text(pmg_reg_row['pms_tb_mcode'])
                    $('#pms_customer').val(findMold['CUSTOMER'])
                    $('#pms_model').val(findMold['MODEL'])
                    $('#pms_mold_name').val(findMold['MOLD_NAME'])
                    $('#pms_part').val(findMold['PART_NO'])
                    $('#pms_loc').val(findMold['MP_LOC'])
                    $('#pms_mark').val(findMold['MARK_NO'])
                    $('#pms_cav2').val(findMold['CAVI_NO'])

                    $('#pms_type').val(pmg_reg_row['pms_tb_type'])
                    $('#pms_defect').val(pmg_reg_row['pms_tb_defect'])
                    $('#pms_detail').val(pmg_reg_row['pms_tb_detail'])
                    $('#pms_cav').val(pmg_reg_row['pms_tb_cav'])
                    $('#pms_qty').val(pmg_reg_row['pms_tb_qty'])

                }, error: (err) => {
                    console.log(err)
                }
            })



        })
    }

    DRAWING_TABLE() {
        const self = this
        this.pms_drawUpload.on('rowClick', (events, row) => {
            select_job_no.PMS_LIST_DRAW(row.getData()['pr_ctrl'], (row) => {
                self.mediaDrawList(row)
            })
            console.log(row.getData())
        })

    }


}

const pmms_table = new PMMS_TABLE_CALL()
export default pmms_table;