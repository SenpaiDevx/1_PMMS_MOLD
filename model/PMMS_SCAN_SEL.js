import '../node_modules/jquery/dist/jquery.min.js'
class PMMS_SCAN_SEL {
    constructor() {
        this.select = '/1_PMMS_MOLD/db_php/select/pms_scan_list.php'
        this.list_code = '/1_PMMS_MOLD/db_php/scanner/scan_mold_code.php'
        this.inOut = '/1_PMMS_MOLD/db_php/scanner/scan_inout.php'
        this.runTime = '/1_PMMS_MOLD/db_php/scanner/scan_runTime.php'
    }
    $list_mold(ctrl_no, callback) {
        $.ajax({
            url: this.select,
            method: 'POST',
            data: {
                'pms': [
                    'pms_list',
                    ctrl_no
                ]
            }, success: (data) => {
                let dl = JSON.parse(data);
                callback(dl);
            }
        })
    }

    $list_mold_code(code, callback) {
        $.ajax({
            url: this.list_code,
            method: 'POST',
            data: {
                'pms': [
                    'onScan',
                    code
                ]
            }, success: (data) => {
                let moldCodeJson = JSON.parse(data)
                callback(moldCodeJson)
            }
        })
    }

    $runtimeInOut(ctrl_no, callback) {
        $.ajax({
            url: this.inOut,
            method: 'POST',
            data: {
                'pms': [
                    ctrl_no
                ]
            }, success: (data) => {
                callback(data)
            }
        })
    }
    $runScan(data, callback) {
        $.ajax({
            url: this.runTime,
            method: 'POST',
            data: {
                'pms': data
                
            }, success: (data) => {
                callback(data)
            }
        })
    }

    $runTimeIn(data, callback) {
        $.ajax({
            url: '/1_PMMS_MOLD/db_php/insert/scan_insert.php',
            method: 'POST',
            data: {
                'pms': data
            }, success: (data) => {
                callback(data)
            }
        })
    }

    $runTimeOut(data, callback) {
        $.ajax({
            url: '/1_PMMS_MOLD/db_php/insert/scan_out.php',
            method: 'POST',
            data: {
                'pms': data
                
            }, success: (data) => {
                callback(data)
            }, error : (err) => {
                console.log(err)
            }
        })
    }
}

const pms_scan_sel = new PMMS_SCAN_SEL();
export default pms_scan_sel