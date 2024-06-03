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
    await createAisleItem(page, store, aisleName, itemName);
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

async function createAisle(
    page: Page,
    storeName: string,
): Promise<[string, number]> {
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

async function createAisleItem(
    page: Page,
    storeName: string,
    aisleName: string,
    itemName: string,
) {
    await page.getByText("Aisle Items", { exact: true }).first().click();
    await page
        .getByLabel(`Aisle`)
        .selectOption({ label: `${aisleName} (${storeName})` });
    await page.getByLabel(`Item`).selectOption({ label: `${itemName}` });
    const price = Math.floor(Math.random() * 200);
    await page.getByLabel("Price").fill(price.toString());
    const size = Math.floor(Math.random() * 1000);
    await page.getByLabel("Size").fill(size.toString());
    const units = ["g", "kg", "mL", "L", "oz", "lb", "qt", "pt", "fl oz"][
        Math.floor(Math.random() * 9)
    ];
    await page.getByLabel("Units").selectOption({ label: units });
    const position = Math.floor(Math.random() * 99);
    await page.getByLabel("Position").fill(position.toString());
    const description = `Description ${Math.floor(Math.random() * 1000)}`;
    await page.getByLabel("Description").fill(description);
    await expect(page.getByText("Save")).toBeVisible();
    await page.getByText("Save").click();
    await expect(
        page.getByTestId(`aisle-item-${storeName}${aisleName}${itemName}`),
    ).toBeVisible();
}
