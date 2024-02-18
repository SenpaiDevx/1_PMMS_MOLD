class SELECT_JOB_NO {
    constructor() {
        this.select = '../db_php/select/pms_regs.php'
        this.allDraw = '../db_php/insert/pmms_addDraw.php'
        this.moldlist = '../db_php/insert/pmms_addProcess.php'
    }
    // PMMS REGISTRATION ONLY
    PMS_REGISTERED(callback) {
        $.ajax({
            url: this.select,
            method: 'POST',
            data: {
                'pms': [
                    'pms_registration',
                ]
            }, success: (data) => {
                const PMS_REGIS = JSON.parse(data)
                callback(PMS_REGIS)
            }
        })
    }


    //PMMS DRAWWING SELCT ONLY
    PMS_DRAW_REG(callback) {
        $.ajax({
            url: '../db_php/select/pms_regs.php',
            method: 'POST',
            data: {
                'pms': [
                    'pms_draw_all',
                ]
            }, success: (data) => {
                const PMS_DRAW = JSON.parse(data)
                callback(PMS_DRAW)
            }
        })
    }

    PMS_LIST_DRAW(pr_control_no, callback) {
        $.ajax({
            url: this.allDraw,
            method: 'POST',
            data: {
                'pms': [
                    'allDraw',
                    pr_control_no
                ]
            }, success: (data) => {
                const PMS_DRAW = JSON.parse(data)
                callback(PMS_DRAW)
            }
        })
    }

    PMS_COUNT_DRAW(callback) {
        $.ajax({
            url: this.select,
            method: 'POST',
            data: {
                'pms': [
                    'pms_draw_count'
                ]
            }, success: (data) => {
                const draw_CNT = JSON.parse(data);
                callback(draw_CNT)
            }
        })
    }

    PMS_MOLD_LIST(pr_control_no, callback){
        $.ajax({
            url: this.moldlist,
            method: 'POST',
            data: {
                'pms': [
                    'listMold',
                    pr_control_no
                ]
            }, success: (data) => {
                const moldListTime = JSON.parse(data)
                callback(moldListTime)
            }
        })
    }

    PMS_MOLD_PLAN(callback) {
        $.ajax({
            url: this.select,
            method: 'POST',
            data: {
                'pms': [
                    'mold_plan'
                ]
            }, success: (data) => {
                const mold_ = JSON.parse(data)
                callback(mold_)
            }
        })
    }


}

const select_job_no = new SELECT_JOB_NO()
export default select_job_no;