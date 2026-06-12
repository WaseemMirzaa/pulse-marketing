import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Post,
  Put,
  UseGuards,
} from "@nestjs/common";
import { Throttle } from "@nestjs/throttler";
import { BlogService } from "./blog.service";
import { CreatePostDto, UpdatePostDto } from "./blog.dto";
import { AdminKeyGuard } from "../content/admin-key.guard";

// ── Public routes ──────────────────────────────────────────────
@Controller("api/blog")
export class BlogController {
  constructor(private readonly blog: BlogService) {}

  @Get()
  listPublished() {
    return this.blog.listPublished();
  }

  @Get("tags")
  tags() {
    return this.blog.allTags();
  }

  @Get("tag/:tag")
  byTag(@Param("tag") tag: string) {
    return this.blog.listByTag(tag);
  }

  @Get(":slug")
  getBySlug(@Param("slug") postSlug: string) {
    return this.blog.getBySlug(postSlug);
  }
}

// ── Admin routes ───────────────────────────────────────────────
@Controller("api/admin/blog")
@UseGuards(AdminKeyGuard)
export class AdminBlogController {
  constructor(private readonly blog: BlogService) {}

  @Get()
  listAll() {
    return this.blog.listAll();
  }

  @Post()
  @Throttle({ medium: { limit: 30, ttl: 60_000 } })
  create(@Body() dto: CreatePostDto) {
    return this.blog.create(dto);
  }

  @Put(":id")
  update(@Param("id") id: string, @Body() dto: UpdatePostDto) {
    return this.blog.update(id, dto);
  }

  @Delete(":id")
  remove(@Param("id") id: string) {
    return this.blog.remove(id);
  }
}
