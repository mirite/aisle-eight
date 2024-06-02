import { test, expect } from "@playwright/test";

test("Is authenticated", async ({ page }) => {
    await page.goto("localhost:8000");

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Aisle Eight/);
    await expect(page.getByText("Dashboard")).toBeVisible();
});

test("Can add items", async ({ page }) => {
    await page.goto("localhost:8000");
    await page.getByText("Dashboard").click();
    await page.getByText("Stores", {}).first().click();
    await expect(page.getByLabel("Name")).toBeVisible();
});
