import { expect, test } from "@playwright/test";
import { testAisle } from "./item-creation/aisle";
import { testAisleItem } from "./item-creation/aisle-item";
import { testItem } from "./item-creation/item";
import { testStore } from "./item-creation/store";

test("Is authenticated", async ({ page }) => {
    await page.goto("localhost:8000");

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Aisle Eight/);
});

test("Can add items", async ({ page }) => {
    page.on("dialog", (dialog) => dialog.accept());
    await page.goto("localhost:8000");

    const { name: store } = await testStore(page);
    const { name: aisle } = await testAisle(page, store);
    const { name: itemName } = await testItem(page);
    await testAisleItem(page, store, aisle, itemName);
});
