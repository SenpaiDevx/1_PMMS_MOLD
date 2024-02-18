// import { Tabulator } from "tabulator-tables"

import '../../node_modules/jquery/dist/jquery.min.js'
import '../../node_modules/tabulator-tables/dist/js/tabulator.min.js'
import '../../node_modules/select2/dist/js/select2.full.min.js'
import '../../node_modules/htmx.org/dist/htmx.min.js'
import '../../public/js/j_ui/jquery-ui.min.js'
class PMMS_SCAN_TABLE {
    constructor() {
        this.scantable = new Tabulator($('#scan_table').get(0), {
            layout: "fitColumns",
            height: 450,
            columns: [
                {
                    title: "PROCESS CODE", field: "scan_code", formatter: (cell) => {
                        return cell.getData()['scan_code']
                    }
                },
                {
                    title: "IN", field: "scan_in", formatter: (cell) => {
                        if (cell.getField() == 'scan_in') {
                            let text_center = cell.getColumn().getElement()// text center
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
                    title: "OUT", field: "scan_out", formatter: (cell) => {
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
                }
            ]
        })
        this.pms_start = new Tabulator($('#scan_start_tb').get(0), {
            layout: "fitDataFill",
            height: 450,
            columns: [
                { title: "PROCESS NAME", field: "scan_proc" },
                { title: "JOB QTY's", field: "scan_job" },
                { title: "PLAN(mins)", field: "scan_mins" }
            ]
        })
        this.SCAN_FUNCTION()
    }
    SCAN_FUNCTION() {
        this.pms_start.on('tableBuilt', () => {
            this.pms_start.setData([
                {
                    id: 0,
                    scan_proc: "GRINDING",
                    scan_job: "2",
                    scan_mins: "120min"
                }
            ])
        })

        this.scantable.on('tableBuilt', () => {
            this.scantable.setData([
                {
                    scan_code: "GS-01",
                    scan_in: "ONGOING",
                    scan_out: ""
                },
                {
                    scan_in: "ONGOING",
                    scan_out: "2024-02-05 15:20"
                }
            ])
        })

        this.pms_start.on('rowClick', (event, row) => {
            var data = row.getData();
            $('#select_scan').dialog({
                title: "PROCESS PLAN LIST CODE",
                modal: true,
                closeOnEscape: false
            })
        })
        this.scantable.on('rowClick', (events, row) => {
            $('#scan_status_diag').dialog({
                modal: true,
                closeOnEscape: false
            })
            $('#scan_status_diag').dialog('open')
        })

        $('#pmsScanINPUT').on('click', (events) => {
            events.preventDefault()
            $('#scan_to_table').find('.row').css({
                'display': 'none'
            })
            $('#select_scan').dialog('close')
        })

        $('#scanClose').on('click', (events) => {
            $('#select_scan').dialog('close')
        })

        $('#done_submit').on('click', (events) => {
            $('#scan_status_diag').dialog('close')
        })
        
        $('#done_close').on('click', (events) => {
            $('#scan_status_diag').dialog('close')
        })
    }
}

const pms_scan = new PMMS_SCAN_TABLE()
export default pms_scan