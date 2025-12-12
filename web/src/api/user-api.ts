import http from "./http";

export const userApi = {
  login(email: string, password: string) {
    return http.post("/login", { email, password });
  }
};
