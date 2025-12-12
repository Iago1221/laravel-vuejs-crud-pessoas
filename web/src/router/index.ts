import { createRouter, createWebHistory } from "vue-router";
import Login from "../pages/login-page.vue";
import Pessoas from "../pages/pessoa/pessoa-list.vue";
import { useAuthStore } from "../stores/auth";

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: "/login", name: "login", component: Login },

    {
      path: "/pessoas",
      name: "pessoas",
      component: Pessoas,
      meta: { requiresAuth: true }
    }
  ]
});

router.beforeEach((to) => {
  const auth = useAuthStore();

  if (to.path === "/login" && auth.isLogged) {
    return "/";
  }

  if (to.meta.requiresAuth && !auth.isLogged) {
    return "/login";
  }

  if (to.path === "/" && !auth.isLogged) {
    return "/login";
  }

  if (to.path === "/" && auth.isLogged) {
    return "/pessoas";
  }

  return true;
});

export default router;