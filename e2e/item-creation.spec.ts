import { test, expect, Page } from "@playwright/test";

test("Is authenticated", async ({ page }) => {
    await page.goto("localhost:8000");

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Aisle Eight/);
    await expect(page.getByText("Dashboard")).toBeVisible();
});

test("Can add items", async ({ page }) => {
    await page.goto("localhost:8000");
    await page.getByText("Dashboard").click();
    const store = await createStore(page);
    const [aisleName, aislePosition] = await createAisle(page, store);
    const itemName = await createItem(page);
});

async function createStore(page: Page) {
    await page.getByText("Stores", {}).first().click();
    await expect(page.getByLabel("Name")).toBeVisible();
    const randomName = `Store ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel("Name").fill(randomName);
    await expect(page.getByText("Save")).toBeVisible();
    await page.getByText("Save").click();
    await expect(page.getByTestId(`store-${randomName}`)).toBeVisible();
    return randomName;
}

async function createAisle(page: Page, storeName: string) {
    await page.getByText("Aisles", {}).first().click();
    await expect(page.getByLabel("Description")).toBeVisible();
    const randomName = `Item ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel("Description").fill(randomName);
    const position = Math.floor(Math.random() * 99);
    await page.getByLabel("Position").fill(position.toString());
    await page.getByLabel("Store").selectOption({ label: storeName });
    await expect(page.getByText("Save")).toBeVisible();
    await page.getByText("Save").click();
    await expect(page.getByTestId(`aisle-${randomName}`)).toBeVisible();
    return [randomName, position];
}

async function createItem(page: Page) {
    await page.getByText("Items", {}).first().click();
    await expect(page.getByLabel("Name")).toBeVisible();
    const randomName = `Item ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel("Name").fill(randomName);
    await expect(page.getByText("Save")).toBeVisible();
    await page.getByText("Save").click();
    await expect(page.getByTestId(`item-${randomName}`)).toBeVisible();
    return randomName;
}
