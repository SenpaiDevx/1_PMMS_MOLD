import '../node_modules/jquery/dist/jquery.min.js'
import '../public/js/j_ui/jquery-ui.min.js'
import pmms_table from '../control/PMMS_JOB_REG/PMMS_TABLE.js'
import pmms_job_bo from '../model/PMMS_INSERT_JO.js'
import qrclass from '../control/PMMS_JOB_REG/PMMS_QRCODE.js'
class PMMS_VIEW {
    constructor() {
        this.REGISTRATION_PMMS()
        this.PMMS_DRAWING()
        this.pms_data = {
            'CONTROL_NO': $('#pms_ctrlno').val(),
            'JOB_ORDER': $('#pms_jobno').val(),
            'MOLD_CODE': $('#mold_ctrl').find(':selected').text(),
            'CUSTOMER': $('#pms_customer').val(),
            'MODEL': $('#pms_model').val(),
            'PART_NO': $('#pms_part').val(),
            'MP_LOC': $('#pms_loc').val(),
            'MARK_NO': $('#pms_mark').val(),
            'TYPE': $('#pms_type').val(),
            'DEFECT': $('#pms_defect').val(),
            'DEFECT_DETAIL': $('#pms_detail').val(),
            'DEFECT_CAV': $('#pms_cav').val(),
            'QUANTITY': $('#pms_qty').val(),
        }
    }
    REGISTRATION_PMMS() {
        // GET ALL input type checkbox inside of parent element the user can't check all simulatenously
        const chkgroup = $('#chkgroup')
        chkgroup.find('input').each((index, value) => {
            $(value).on('change', function () {
                const checkboxes = chkgroup.find('input:checked').length;
                if (checkboxes >= 2) {
                    $(this).prop('checked', false);
                }
            })
        })

       



       

        $('#pms_insert').on('click', (events) => {
            pmms_job_bo.REG_VALIDATION($('#pms_ctrlno').val(), (data) => {
                if (!data['msg']) {
                    if (!$('#pms_ctrlno').val().length) {
                        console.log('this empty')
                    } else {
                        const pms_data = {
                            'CONTROL_NO': $(document).find('#pms_ctrlno').val(),
                            'JOB_ORDER': $(document).find('#pms_jobno').val(),
                            'MOLD_CODE': $(document).find('#mold_ctrl').find(':selected').text(),
                            'CUSTOMER': $(document).find('#pms_customer').val(),
                            'MODEL': $(document).find('#pms_model').val(),
                            'PART_NO': $(document).find('#pms_part').val(),
                            'MP_LOC': $(document).find('#pms_loc').val(),
                            'MARK_NO': $(document).find('#pms_mark').val(),
                            'TYPE': $(document).find('#chkgroup').find('input:checked').val(),
                            'DEFECT': $(document).find('#pms_defect').val(),
                            'DEFECT_DETAIL': $(document).find('#pms_detail').val(),
                            'DEFECT_CAV': $(document).find('#pms_cav').val(),
                            'QUANTITY': $(document).find('#pms_qty').val(),
                            'CAVITY' : $(document).find('#pms_scan-cavs').val(),
                            'JOB_QTY' : $(document).find('#pms_jobQty').val(),
                            'CHARGE' : $(document).find('#pms_charge').find(':selected').val(),
                            'DRAWING_NO' : $(document).find('#pms_draw').val(),
                            'PART_NAME' : $(document).find('#pms_partName').val(),
                            'TARGET_DATE' : $(document).find('#pms_targetDate').val()
                        }
                        pmms_job_bo.InsertJO(pms_data, (row) => {
                            const lastRow = row[row.length - 1]
                            pmms_table.pms_reg.addData([
                                {
                                    pms_tb_ctrl: pms_data['CONTROL_NO'],
                                    pms_tb_mcode: pms_data['MOLD_CODE'],
                                    pms_tb_model: pms_data['MODEL'],
                                    pms_tb_modelm: $('#pms_mold_name').val(),
                                    pms_tb_type: pms_data['TYPE'],
                                    pms_tb_defect: pms_data['DEFECT'],
                                    pms_tb_detail: pms_data['DEFECT_DETAIL'],
                                    pms_tb_cav: pms_data['DEFECT_CAV'],
                                    pms_tb_qty: pms_data['QUANTITY'],
                                    pms_tb_order: pms_data['JOB_ORDER'],
                                }

                            ])
                            pmms_table.weekGen((data) => {
                                $('#pms_jobno').val(data)
                            })
                            document.location.reload(true)
                            pmms_table.pms_reg.redraw(true)// due table glitch after modifying 
                            console.log(row)
                        })
                    }
                } else {
                    var valid_ctrl = $('#modal_valid').dialog({
                        open: (events, ui) => {
                            $('#pms_insert').prop("disabled", true)
                        },
                        close: (events, ui) => {
                            $('#pms_insert').prop("disabled", false)
                        },
                        modal: true,
                        buttons: [{
                            text: 'Cancel',
                            click: function () {
                                $(this).dialog('close');
                                $('#pms_insert').prop("disabled", false)
                                $('#pms_ctrlno').val(null);
                                $('#pms_ctrlno').focus();
                            }
                        }],
                        closeOnEscape: false
                    })

                    valid_ctrl.dialog('open')
                    $('#pms_ctrlno').focus();
                }
            })



        })

    }

    PMMS_DRAWING() {
        pmms_job_bo.REG_DRAW_CTRL((data) => {
            // console.log(data)
            $('#pr_control_no').select2({
                theme: 'classic',
                data: data,
                templateSelection: (state) => {
                    pmms_job_bo.REG_DRAW_VALIDATION(state.text, (cell) => {

                        // console.log(cell)
                        $('#pms_drawNo').val(cell['id'])
                    })
                    return state.text
                }
            })
        })
        $('#pr_control_no').on('mouseenter mouseleave', (events) => {
            pmms_job_bo.REG_DRAW_CTRL((data) => {
                console.log(data)
                $('#pr_control_no').select2({
                    theme: 'classic',
                    data: data,
                    templateSelection: (state) => {
                        pmms_job_bo.REG_DRAW_VALIDATION(state.text, (cell) => {
                            console.log(cell)
                            $('#pms_drawNo').val(cell['id'])
                        })
                        return state.text
                    }
                })
            })
        })



        $('#pms_saveDraw').on('click', (events) => {
            var draw_info = {
                "PMS_CONTROL_NO": $('#pr_control_no option:selected').text(),
                "PMS_DRAW_NO": $('#pms_drawNo').val()
            }
            pmms_job_bo.REG_DRAW_INSERT(draw_info, (res) => {
                if (res['msg'] == 'TRUE') {
                    pmms_table.pms_drawUpload.addData([{
                        pr_ctrl: draw_info['PMS_CONTROL_NO'],
                        pms_draw: draw_info['PMS_DRAW_NO']
                    }])
                    // alert('unique')
                } else {
                    alert('existed')
                }
            })
        })


    }
}
const pmms_view = new PMMS_VIEW()
export default pmms_view