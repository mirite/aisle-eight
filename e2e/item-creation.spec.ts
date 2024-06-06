import { expect, Page, test } from "@playwright/test";
import { testAisle } from "./item-creation/aisle";
import { testStore } from "./item-creation/store";

test("Is authenticated", async ({ page }) => {
    await page.goto("localhost:8000");

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Aisle Eight/);
    await expect(page.getByText("Dashboard")).toBeVisible();
});

test("Can add items", async ({ page }) => {
    page.on("dialog", (dialog) => dialog.accept());
    await page.goto("localhost:8000");
    await page.getByText("Dashboard").click();
    const { name: store } = await testStore(page);
    const { name: aisle } = await testAisle(page, store);
    const itemName = await createItem(page);
    await createAisleItem(page, store, aisle, itemName);
});

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
