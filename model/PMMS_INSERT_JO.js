import '../node_modules/jquery/dist/jquery.min.js'
class PMMS_JOB_NO {
    constructor() {
        this.insert_pms = '../db_php/select/pms_regs.php';
        this.addCtrl = '../db_php/insert/pmms_addDraw.php'
        this.insertDraw = '../db_php/insert/pmms_jobOrder.php'
        this.insertMold = '../db_php/insert/pmms_addProcess.php'
    }
    // PMMS REGISTRATION 
    InsertJO(data, callback) {
        $.ajax({
            url: this.insertDraw,
            method: 'POST',
            data: {
                'pms': [
                    'JO_REG',
                    data
                ]
            }, success: (jo) => {
                const regist = JSON.parse(jo)
                callback(regist)
                // console.log(regist)
            }, error: (err) => {

                console.log(err)
            }
        })
    }

    REG_VALIDATION(id, callback) {
        $.ajax({
            url: this.insert_pms,
            method: 'POST',
            data: {
                'pms': [
                    'valid_ctrlno',
                    id
                ]
            }, success: (data) => {
                const validData = JSON.parse(data)
                callback(validData)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    // PMMS DRAWING
    REG_DRAW_CTRL(callback) {
        $.ajax({
            url: this.insert_pms,
            method: "POST",
            data: {
                'pms': [
                    'prControlNo'
                ]
            }, success: (data) => {
                const pr_ctrl = JSON.parse(data)
                callback(pr_ctrl)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    REG_DRAW_INSERT(data, callback) {
        //if user 1st time to uploading then control number is does'nt exist then generate draw Control start 0 ex: "DRAW-000000"
        $.ajax({
            url: this.insert_pms,
            method: "POST",
            data: {
                'pms': [
                    'regDraw',
                    data
                ]
            },
            success: function (row) {
                const drawJson = JSON.parse(row)
                callback(drawJson)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    REG_DRAW_VALIDATION(pr_control_no, callback) {
        $.ajax({
            url: this.insert_pms,
            method: "POST",
            data: {
                'pms': [
                    'validDraw',
                    pr_control_no
                ]
            },
            success: function (row) {
                const drawValid = JSON.parse(row)
                callback(drawValid)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    REG_INSERT_FILE(pr_control_no, callback) {
        $.ajax({
            url: this.addCtrl,
            method: "POST",
            data: {
                'pms': [
                    "addDraw",
                    pr_control_no
                ]
            },
            success: function (row) {
                const draw_result = JSON.parse(row)
                callback(draw_result)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    /// PLANNING
    PMS_MOLD_INSERT(data, callback) {
        $.ajax({
            url: this.insertMold,
            method: 'POST',
            data: {
                'pms': [
                    'mold_plan',
                    data
                ]
            }, success: (data) => {
                const res = JSON.parse(data);
                callback(res)
            }
        })
    }

}

const pmms_job_bo = new PMMS_JOB_NO()
export default pmms_job_bo