import http from "./http";

export const pessoaApi = {
  list() {
    return http.get("/pessoas");
  },
  find(id: number) {
    return http.get(`/pessoas/${id}`);
  },
  delete(id: number) {
    return http.delete(`/pessoas/${id}`);
  },
  create(nome: string, tipo: string, documento: string, telefone: string, email: string) {
    return http.post("/pessoas", { nome, tipo, documento, telefone, email });
  },
  update(id: number, nome: string, telefone: string, email: string) {
    return http.put(`/pessoas/${id}`, { nome, telefone, email });
  }
};
