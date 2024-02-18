class PMMS_UPDATE_REG {
    constructor() {
        this.update = '../db_php/update/pms_reg_update.php'
        this.drawUpdate = '../db_php/update/pms_draw_update.php'
        this.mold_plan = '../db_php/update/pms_plan_update.php'
    }

    PMMS_REG_LIST_UPDATE(row, callback) {
        console.log(row)
        $.ajax({
            url: this.update,
            method: 'POST',
            data: {
                'pms': [
                    'pms_regUp',
                    row
                ]
            }, success: (data) => {
                const update = JSON.parse(data)
                callback(update)
            }, error: (err) => {
                console.log(err)
            }
        })
    }

    PMS_DRAW_UPDATE (data, callback) {
        $.ajax({
            url: this.drawUpdate,
            method: 'POST',
            data: {
                'pms': [
                    'drawUpdate',
                    data
                ]
            }, success: (data) => {
                console.log(data)
            }, error: (err) => {
                console.log(err)
            }
        })
    }
    PMS_PLAN_UPDATE(data, callback) {
        $.ajax({
            url: this.mold_plan,
            method: 'POST',
            data: {
                'pms': [
                    'plan_update',
                    data
                ]
            }, success: (data) => {
                
            }, error: (err) => {
                console.log(err)
            }
        })
    } 
}
const pms_update = new PMMS_UPDATE_REG()
export default pms_update;