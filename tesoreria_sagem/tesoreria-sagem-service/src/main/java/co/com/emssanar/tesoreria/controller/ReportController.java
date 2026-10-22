package co.com.emssanar.tesoreria.controller;

import co.com.emssanar.tesoreria.service.ReportExportService;
import co.com.emssanar.tesoreria.service.ReportExportService.DownloadResponse;
import org.springframework.http.ContentDisposition;
import org.springframework.http.HttpHeaders;
import org.springframework.http.MediaType;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;
import org.springframework.web.server.ResponseStatusException;

import static org.springframework.http.HttpStatus.BAD_REQUEST;

@RestController
@RequestMapping("/api/sagem/reportes")
// @CrossOrigin(origins = "*")
public class ReportController {

    private final ReportExportService reportExportService;

    public ReportController(ReportExportService reportExportService) {
        this.reportExportService = reportExportService;
    }

    @PostMapping(value = "/tesoreria", produces = "text/csv")
    public ResponseEntity<byte[]> descargarTesoreria(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtctacobro,
            @RequestParam(required = false) String txtidrad,
            @RequestParam(required = false) String txtdocto,
            @RequestParam(required = false) String fini,
            @RequestParam(required = false) String ffin) {
        return csv(reportExportService.descargarTesoreria(txtnit, txtctacobro, txtidrad, txtdocto, fini, ffin));
    }

    @PostMapping(value = "/tesoreria/radicados", produces = "text/csv")
    public ResponseEntity<byte[]> descargarTesoreriaRadicados(@RequestParam(required = false) String txtidrad) {
        return csv(reportExportService.descargarTesoreriaRadicados(txtidrad));
    }

    @PostMapping(value = "/tesoreria/nit-periodo", produces = "text/csv")
    public ResponseEntity<byte[]> descargarTesoreriaNitPeriodo(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtfini,
            @RequestParam(required = false) String txtffin) {
        return csv(reportExportService.descargarTesoreriaNitPeriodo(txtnit, txtfini, txtffin));
    }

    @PostMapping(value = "/tesoreria/nit-cuenta-cobro", produces = "text/csv")
    public ResponseEntity<byte[]> descargarTesoreriaNitCuenta(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtcta,
            @RequestParam(required = false) String txtctacobro) {
        String cta = firstNonBlank(txtcta, txtctacobro);
        if (isBlank(txtnit) || isBlank(cta)) {
            throw new ResponseStatusException(BAD_REQUEST,
                    "Faltan parametros: txtnit y txtcta/txtctacobro son requeridos");
        }
        return csv(reportExportService.descargarTesoreriaNitCuenta(txtnit, cta));
    }

    @PostMapping(value = "/tesoreria/nit-documento", produces = "text/csv")
    public ResponseEntity<byte[]> descargarTesoreriaNitDocumento(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtdocto) {
        return csv(reportExportService.descargarTesoreriaNitDocumento(txtnit, txtdocto));
    }

    @PostMapping(value = "/cartera", produces = "text/csv")
    public ResponseEntity<byte[]> descargarCartera(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtctacobro,
            @RequestParam(required = false) String txtidrad,
            @RequestParam(required = false) String txtdocto,
            @RequestParam(required = false) String fini,
            @RequestParam(required = false) String ffin) {
        return csv(reportExportService.descargarCartera(txtnit, txtctacobro, txtidrad, txtdocto, fini, ffin));
    }

    @PostMapping(value = "/cartera/radicados", produces = "text/csv")
    public ResponseEntity<byte[]> descargarCarteraRadicados(@RequestParam(required = false) String txtidrad) {
        return csv(reportExportService.descargarCarteraRadicados(txtidrad));
    }

    @PostMapping(value = "/cartera/nit-periodo", produces = "text/csv")
    public ResponseEntity<byte[]> descargarCarteraNitPeriodo(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtfini,
            @RequestParam(required = false) String txtffin) {
        return csv(reportExportService.descargarCarteraNitPeriodo(txtnit, txtfini, txtffin));
    }

    @PostMapping(value = "/cartera/nit-cuenta-cobro", produces = "text/csv")
    public ResponseEntity<byte[]> descargarCarteraNitCuenta(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtcta,
            @RequestParam(required = false) String txtctacobro) {
        String cta = firstNonBlank(txtcta, txtctacobro);
        if (isBlank(txtnit) || isBlank(cta)) {
            throw new ResponseStatusException(BAD_REQUEST,
                    "Faltan parametros: txtnit y txtcta/txtctacobro son requeridos");
        }
        return csv(reportExportService.descargarCarteraNitCuenta(txtnit, cta));
    }

    @PostMapping(value = "/impuestos", produces = "text/csv")
    public ResponseEntity<byte[]> descargarImpuestos(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtctacobro,
            @RequestParam(required = false) String txtidrad,
            @RequestParam(required = false) String txtdocto,
            @RequestParam(required = false) String fini,
            @RequestParam(required = false) String ffin) {
        return csv(reportExportService.descargarImpuestos(txtnit, txtctacobro, txtidrad, txtdocto, fini, ffin));
    }

    @PostMapping(value = "/impuestos/radicados", produces = "text/csv")
    public ResponseEntity<byte[]> descargarImpuestosRadicados(@RequestParam(required = false) String txtidrad) {
        return csv(reportExportService.descargarImpuestosRadicados(txtidrad));
    }

    @PostMapping(value = "/impuestos/nit-periodo", produces = "text/csv")
    public ResponseEntity<byte[]> descargarImpuestosNitPeriodo(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtfini,
            @RequestParam(required = false) String txtffin) {
        return csv(reportExportService.descargarImpuestosNitPeriodo(txtnit, txtfini, txtffin));
    }

    @PostMapping(value = "/impuestos/nit-cuenta-cobro", produces = "text/csv")
    public ResponseEntity<byte[]> descargarImpuestosNitCuenta(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtcta,
            @RequestParam(required = false) String txtctacobro) {
        String cta = firstNonBlank(txtcta, txtctacobro);
        if (isBlank(txtnit) || isBlank(cta)) {
            throw new ResponseStatusException(BAD_REQUEST,
                    "Faltan parametros: txtnit y txtcta/txtctacobro son requeridos");
        }
        return csv(reportExportService.descargarImpuestosNitCuenta(txtnit, cta));
    }

    @PostMapping(value = "/impuestos/nit-documento", produces = "text/csv")
    public ResponseEntity<byte[]> descargarImpuestosNitDocumento(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtdocto) {
        return csv(reportExportService.descargarImpuestosNitDocumento(txtnit, txtdocto));
    }

    @GetMapping(value = "/recobros/radicado", produces = "text/csv")
    public ResponseEntity<byte[]> descargarRecobroPorRadicado(@RequestParam("id_rad") String idRad) {
        return csv(reportExportService.descargarRecobroPorRadicado(idRad));
    }

    @GetMapping(value = "/recobros/cuenta-cobro", produces = "text/csv")
    public ResponseEntity<byte[]> descargarRecobroPorCuentaCobro(
            @RequestParam(required = false) String id_nit,
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String id_numero_cuenta_cobro,
            @RequestParam(required = false) String txtctacobro) {
        String nit = firstNonBlank(id_nit, txtnit);
        String numeroCuentaCobro = firstNonBlank(id_numero_cuenta_cobro, txtctacobro);
        if (isBlank(nit) || isBlank(numeroCuentaCobro)) {
            throw new ResponseStatusException(BAD_REQUEST, "Faltan parametros: nit y cuenta de cobro son requeridos");
        }
        return csv(reportExportService.descargarRecobroPorCuentaCobro(nit, numeroCuentaCobro));
    }

    @GetMapping(value = "/recobros/factura", produces = "text/csv")
    public ResponseEntity<byte[]> descargarRecobroPorFactura(
            @RequestParam(required = false) String id_nit,
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String id_factura,
            @RequestParam(required = false) String txtdocto) {
        String nit = firstNonBlank(id_nit, txtnit);
        String factura = firstNonBlank(id_factura, txtdocto);
        if (isBlank(nit) || isBlank(factura)) {
            throw new ResponseStatusException(BAD_REQUEST, "Faltan parametros: nit y factura son requeridos");
        }
        return csv(reportExportService.descargarRecobroPorFactura(nit, factura));
    }

    @PostMapping(value = "/cruce", produces = "text/csv")
    public ResponseEntity<byte[]> descargarCruce(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtctacobro,
            @RequestParam(required = false) String txtidrad,
            @RequestParam(required = false) String txtdocto,
            @RequestParam(required = false) String fini,
            @RequestParam(required = false) String ffin) {
        return csv(reportExportService.descargarCruce(txtnit, txtctacobro, txtidrad, txtdocto, fini, ffin));
    }

    @PostMapping(value = "/fepa", produces = "text/csv")
    public ResponseEntity<byte[]> descargarFepa(
            @RequestParam(required = false) String txtnit,
            @RequestParam(required = false) String txtctacobro,
            @RequestParam(required = false) String txtidrad,
            @RequestParam(required = false) String txtdocto,
            @RequestParam(required = false) String fini,
            @RequestParam(required = false) String ffin) {
        return csv(reportExportService.descargarFepa(txtnit, txtctacobro, txtidrad, txtdocto, fini, ffin));
    }

    private ResponseEntity<byte[]> csv(DownloadResponse response) {
        HttpHeaders headers = new HttpHeaders();
        headers.setContentType(new MediaType("text", "csv"));
        headers.setContentDisposition(ContentDisposition.attachment().filename(response.fileName()).build());
        return ResponseEntity.ok().headers(headers).body(response.content());
    }

    private String firstNonBlank(String... values) {
        for (String value : values) {
            if (!isBlank(value)) {
                return value;
            }
        }
        return null;
    }

    private boolean isBlank(String value) {
        return value == null || value.isBlank();
    }
}
