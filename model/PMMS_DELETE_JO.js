class PMMS_REG_DELETE {
    constructor() {
        this.delete = '../db_php/delete/pms_reg_del.php'
        this.deleteDraw = '../db_php/delete/pms_draw_del.php'
        this.delete_mold_plan = '../db_php/delete/pms_plan_del.php'
    }
    PMMS_DELETE_REG(data, callback) {
        $.ajax({
            url: this.delete,
            method: 'POST',
            data: {
                'pms': [
                    'pms_regListDel',
                    data,
                ]
            }, success: (data) => {
                const onDel = JSON.parse(data)
                callback(onDel)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    PMMS_DELETE_DRAW(pms_id, callback) {
        $.ajax({
            url: this.deleteDraw,
            method: 'POST',
            data: {
                'pms': [
                    'delDraw',
                    pms_id
                ]
            }, success: (data) => {
                const delDrawID = JSON.parse(data)
                callback(delDrawID)
            }, error: (err) => {
                console.log(err)
            }
        })
    }
    PMS_DELPLAN(pr_control_no, callback) {
        $.ajax({
            url: this.delete_mold_plan,
            method: 'POST',
            data: {
                'pms': [
                    'mold_delete',
                    pr_control_no
                ]
            }, success: (data) => {
                const deMold = JSON.parse(data)
                callback(deMold)
            }, error: (err) => {
                console.log(err)
            }
        })
    }
}

const pms_del = new PMMS_REG_DELETE()
export default pms_del;