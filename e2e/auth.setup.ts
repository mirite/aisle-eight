import { test as setup, expect } from "@playwright/test";
import { config } from "dotenv";
config();
const authFile = "playwright/.auth/user.json";

setup("authenticate", async ({ page }) => {
    // Perform authentication steps. Replace these actions with your own.
    await page.goto("localhost:8000/login");
    await page.getByLabel("Email").fill(process.env.TEST_USER_EMAIL!);
    await page.getByLabel("Password").fill(process.env.TEST_USER_PASSWORD!);
    await page.getByRole("button", { name: "Log In" }).click({ force: true });
    // Wait until the page receives the cookies.
    await expect(page.getByText("Shop Now")).toBeVisible();
    await page.context().storageState({ path: authFile });
});
