# Description

**Introducing the Hipsy Events Plugin for Wordpress**

The Hipsy Events Plugin is a tool that seamlessly synchronizes events created on Hipsy.nl, with your WordPress website. With just a few simple steps, you can effortlessly connect your Hipsy account to your WordPress site and your events on Hipsy.nl will be synchronized with your website.

**The benefits of using the Hipsy Events Plugin:**

1. **Streamlined event management**: The plugin revolutionizes your event management workflow by eliminating the need for manual event creation in WordPress. Simply create events on Hipsy.nl, and they will automatically appear on your WordPress website, saving you valuable time and effort.

2. **Error-free synchronization**: Manual entry of events can lead to mistakes and inconsistencies. With the plugin's seamless synchronization, you can ensure that all event details, including dates, times, tickets, prices, descriptions, and images, are accurately transferred from Hipsy to your WordPress site, maintaining data integrity.

3. **Effortless updates**: Make changes to your events on Hipsy.nl, and rest assured that those updates will be automatically reflected on your WordPress website. Whether it's modifying event details, ticket prices, or availability, the plugin ensures that your website is always up-to-date with the latest information.

# Installation

This section describes how to install the plugin and get it working:

1. [`Download the plugin here`](https://github.com/hipsynl/hipsy-wordpress-events/releases/download/v1.2.0/hipsy-events.zip)
2. Login as administrator on your own Wordpress website
3. Navigate to _Plugins_, click _Add New_ and then click _Upload Plugin_ at the top of the page
4. Select and upload the .zip file you downloaded at step 1
5. Activate the plugin through the Plugins overview page

# Configuration

Once you've installed the plugin, you have to follow a few steps to configure your Hipsy account before you can publish your events on your website. To configure your Hipsy account your need to create an API key in the Hipsy dashboard.

1. Login to your [Hipsy dashboard](https://hipsy.nl/app)
2. Click on your organisation name and click on `Koppelingen`
3. Click on the green button 'Nieuwe API Key' to create a key and give it a name (e.g. My wordpress website).
4. Copy the generated key.
5. Navigate to your Wordpress admin panel and click in the menu at `Hipsy events` (only vissible once you've activated the plugin)
6. Click on Hipsy settings
7. Paste the generated API key and click `Save settings`
8. Select to organisation of which you want to synchronize the events.

Once you've done those steps. The events are automatically synchronized and published on your website. Once you add or modify events on Hipsy.nl, at will also be added and modified on your website.

## Usage

### Events listing

If you have successfully installed and configured the plugin on your Wordpress website. An events link will be added
to your menu. This will navigate to a page which list all your upcoming events.

You are free to remove this link from your menu. Second option is to add the events listing on an existing page. Open the editor of this page and when adding a new block, search for the `Hipsy events list` block.

### Manually add events

It is possible to manually add events to your Wordpress website which you didn't published on Hipsy. Click on the `Add event` menu (under Hipsy events) to add a new event only to your Wordpress website.

### Wordpress shortcode

You can also use legacy Wordpress shortcodes for older Wordpress templates with widget support. Or, you can use shortcodes inside a Gutenberg Shortcode block. Use the following shortcode:

```
[hipsy_events limit=10]
```

You can change `limit` into any number you wish to set the amount of events to display. You can also remove the limit parameter and just use `[hipsy_events]`.

# Frequently Asked Questions

### Q: What is an API key?

A: To make the synchronization process secure and convenient, the Hipsy Events Plugin utilizes an API key. An API key acts as a unique identifier that grants your WordPress website permission to access and interact with Hipsy. This secure integration ensures that your data remains protected while enabling seamless communication between platforms. You can [generate your API key here](https://hipsy.nl/app/api-keys).

### Q: What kind of support do you offer for the plugin?

A: We offer limited support for the plugin as it is provided free of charge. While we are committed to assisting our users, it's important to note that our resources are constrained, and we may not be able to address all individual queries promptly.

### Q: Where can I get help if I encounter issues with the plugin?

A: If you encounter any issues or have questions about the plugin, we encourage you to open an [issue on our GitHub repository](https://github.com/hipsynl/hipsy-wordpress-events/issues). This platform allows you to seek help from the broader community, including experienced users and developers who can share their insights and expertise.

# Development

If you want to contribute to the development of this plugin or build it from source, follow these steps.

## Development Setup

### Docker Development Environment

For local development, you can use Docker to run a WordPress instance with the plugin:

1. **Start the Docker environment**:

   ```bash
   docker-compose up -d
   ```

2. **Access WordPress**:

   - WordPress will be available at `http://localhost:8080`
   - Admin credentials: `admin` / `admin`
   - The plugin is automatically mounted from the current directory

3. **Stop the environment**:
   ```bash
   docker-compose down
   ```

The Docker setup includes:

- WordPress 6.9.0 with PHP 8.2
- MySQL 8.0 database
- Automatic WordPress installation and configuration
- Plugin mounted as a volume for live development

## Building the Plugin

To create a distributable `.zip` file of the plugin, you can use the provided build script. This script will install dependencies, compile assets using Vite and Tailwind CSS 4, and package the necessary files.

### Prerequisites

- **Node.js**: Ensure you have Node.js installed.
- **Yarn** or **npm**: The script will try to use `yarn` first, then fall back to `npm`.
- **Zip**: A command-line zip utility (usually available by default on macOS and Linux).

### Running the Build Script

Open your terminal in the project root and run:

```bash
chmod +x build_zip.sh # Ensure the script is executable
./build_zip.sh
```

### What the Script Does

1.  **Installs Dependencies**: Runs `yarn install` or `npm install`.
2.  **Builds Assets**:
    - Compiles CSS and processes Tailwind CSS 4 using Vite.
3.  **Packages**: Creates a temporary directory, copies all necessary files (PHP files, blocks, templates, images, compiled styles), and removes unnecessary development files (like node_modules).
4.  **Zips**: Archives the plugin into `hipsy-events.zip`.

You can then proceed to install `hipsy-events.zip` on your WordPress site as described in the **Installation** section.
