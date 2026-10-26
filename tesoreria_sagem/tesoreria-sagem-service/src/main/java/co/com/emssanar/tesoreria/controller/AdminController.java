package co.com.emssanar.tesoreria.controller;

import co.com.emssanar.tesoreria.service.AdminCrudService;
import java.util.List;
import java.util.Map;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

@RestController
@RequestMapping("/api/sagem/admin")
@CrossOrigin(originPatterns = "*")
public class AdminController {

    private final AdminCrudService adminCrudService;

    public AdminController(AdminCrudService adminCrudService) {
        this.adminCrudService = adminCrudService;
    }

    @GetMapping("/users/login")
    public Map<String, Object> login(@RequestParam String usuario, @RequestParam String pass) {
        return Map.of("tipo", adminCrudService.loginUser(usuario, pass));
    }

    @GetMapping("/emails")
    public List<Map<String, Object>> listEmails() {
        return adminCrudService.listEmails();
    }

    @GetMapping("/emails/{id}")
    public Map<String, Object> getEmail(@PathVariable long id) {
        return adminCrudService.getEmail(id);
    }

    @PostMapping("/emails")
    public ResponseEntity<?> createEmail(@RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.createEmail(body)));
    }

    @PutMapping("/emails/{id}")
    public ResponseEntity<?> updateEmail(@PathVariable long id, @RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.updateEmail(id, body)));
    }

    @DeleteMapping("/emails/{id}")
    public ResponseEntity<?> deleteEmail(@PathVariable long id) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.deleteEmail(id)));
    }

    @GetMapping("/pqrs")
    public List<Map<String, Object>> listPqrs() {
        return adminCrudService.listPqrs();
    }

    @GetMapping("/pqrs/{id}")
    public Map<String, Object> getPqrs(@PathVariable long id) {
        return adminCrudService.getPqrs(id);
    }

    @PutMapping("/pqrs/{id}")
    public ResponseEntity<?> updatePqrs(@PathVariable long id, @RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.updatePqrs(id, body)));
    }

    @DeleteMapping("/pqrs/{id}")
    public ResponseEntity<?> deletePqrs(@PathVariable long id) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.deletePqrs(id)));
    }

    @GetMapping("/base-unoe")
    public List<Map<String, Object>> listBaseUnoe(@RequestParam long numeroRadicado) {
        return adminCrudService.listBaseUnoeByRadicado(numeroRadicado);
    }

    @GetMapping("/base-unoe/{numeroRadicado}")
    public Map<String, Object> getBaseUnoe(@PathVariable long numeroRadicado) {
        return adminCrudService.getBaseUnoeByRadicado(numeroRadicado);
    }

    @PostMapping("/base-unoe")
    public ResponseEntity<?> createBaseUnoe(@RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.createBaseUnoe(body)));
    }

    @PutMapping("/base-unoe/{idUnoe}")
    public ResponseEntity<?> updateBaseUnoe(@PathVariable long idUnoe, @RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.updateBaseUnoe(idUnoe, body)));
    }

    @DeleteMapping("/base-unoe/{idUnoe}")
    public ResponseEntity<?> deleteBaseUnoe(@PathVariable long idUnoe) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.deleteBaseUnoe(idUnoe)));
    }

    @GetMapping("/cubos")
    public List<Map<String, Object>> listCubos() {
        return adminCrudService.listCubos();
    }

    @GetMapping("/cubos/{nitips}")
    public Map<String, Object> getCubos(@PathVariable long nitips) {
        return adminCrudService.getCubosByNitIps(nitips);
    }

    @PostMapping("/cubos")
    public ResponseEntity<?> createCubos(@RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.createCubos(body)));
    }

    @PutMapping("/cubos/{id}")
    public ResponseEntity<?> updateCubos(@PathVariable long id, @RequestBody Map<String, Object> body) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.updateCubos(id, body)));
    }

    @DeleteMapping("/cubos/{id}")
    public ResponseEntity<?> deleteCubos(@PathVariable long id) {
        return ResponseEntity.ok(Map.of("updated", adminCrudService.deleteCubos(id)));
    }

    @GetMapping("/cubos/indicadores")
    public List<Map<String, Object>> listIndicadores() {
        return adminCrudService.listIndicadores();
    }
}
